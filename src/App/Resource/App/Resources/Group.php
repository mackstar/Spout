<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Resources;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use PDO;

/**
 * Resources Index
 *
 * @Db
 */
class Group extends ResourceObject
{
    use DbSetterTrait;
    use ResourceInject;

    protected $table = 'resources';

    public function onGet($type, $query = [])
    {
        // Get resources list (title/meta)
        $ids = $this->getList($type, $query);

        $this['_embedded'] = $this->resource->get->uri('app://spout/resources/batch')
                ->eager
                ->withQuery(['type' => $type, 'ids' => $ids])
                ->request()['_embedded'];
        // Get resource_fields from $type order by weight
        // Get field_values by (table name) where resource_ids in ids
        // Map fields to retrieved fields
        return $this;
    }

    private function getList($type, $query) {
        // Get all fields for resource type
        $fields = $this->resource->get->uri('app://spout/resources/resourcefields')
                ->eager
                ->withQuery(['type' => $type])
                ->request()
                ->body['resource_fields'];

        // Does the field have a query against it?
        $queryFields = array_filter($fields, function ($field) use ($query) {
            return isset($query[$field['slug']])? true : false; 
        });
        

        $queries = [];
        // Group queries into field_value type in order to be able to
        // make fewer requests
        foreach($queryFields as $field) {
            if (empty($queries[$field['field_type']])) {
                $queries[$field['field_type']] = [];
            }
 
            $queries[$field['field_type']][] = [
                'value' => $query[$field['slug']],
                'resource_field_id' => $field['id'],
                'key' => $field['slug']
            ];
        }


        $matches = [];
        // Check each field type for a match
        foreach ($queries as $fieldType => $fieldTypeQueries) {

            $qb = $this->db->createQueryBuilder();
            $qb->select('fv.*', 'COUNT(resource_id) AS resource_count')
                ->from('field_values_' . $fieldType, 'fv');

            $i = 0;
            $orx = $qb->expr()->orX();

            // Loop field types and query for a match
            foreach($fieldTypeQueries as $fieldTypeQuery) {
                $orx->add(
                    $qb->expr()->andX(
                        "fv.value = ?",
                        "fv.resource_field_id = ?"
                    )
                );
                $qb->setParameter($i, $fieldTypeQuery['value']);
                $qb->setParameter($i+1, $fieldTypeQuery['resource_field_id']);
                $i = $i+2;
            }
            $qb->where($orx);
            $qb->having('resource_count >= ' . ($i/2));
            $qb->groupBy('resource_id');
            $stmt = $qb->execute();
            $response = $stmt->fetchAll();

            // allow for fields that aren't part of a query type (ie native field)
            // these include:
            //     id
            //     title
            //     slug
            //     category

            // Loop responses to tell how many matches have been added.
            if (!empty($response)) {
                foreach($response as $fieldMatch) {
                    if (!isset($matches[$fieldMatch['resource_id']])) {
                        $matches[$fieldMatch['resource_id']] = 0;
                    }
                    $matches[$fieldMatch['resource_id']]++;
                }
            }
        }

        // Check to see all matches match all queries
        $ids = [];
        foreach ($matches as $id => $matchCount) {
            if ($matchCount >= count($query)) {
                $ids[] = $id;
            }
        }

        return $ids;

    }
}