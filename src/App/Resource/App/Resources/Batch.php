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
use Mackstar\Spout\Provide\Resource\FieldMapperTrait;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use PDO;

/**
 * Resources Index
 *
 * @Db
 */
class Batch extends ResourceObject
{
    use DbSetterTrait;
    use ResourceInject;
    use FieldMapperTrait;

    protected $table = 'resources';

    public function onGet($type, $ids = [])
    {
        // Get all fields for resource type
        $fields = $this->resource->get->uri('app://spout/resources/resourcefields')
                ->eager
                ->withQuery(['type' => $type])
                ->request()
                ->body['resource_fields'];

        $fieldTypes = [];
        foreach ($fields as $field) {
            if (!in_array($field['field_type'], $fieldTypes)) {
                $fieldTypes[] = $field['field_type'];
            }
        }

        $fieldData = [];
        foreach ($fieldTypes as $fieldType) {
            $qb = $this->db->createQueryBuilder();
            $qb->select('fv.*')
                ->from('field_values_' . $fieldType, 'fv');

            $orx = $qb->expr()->orX();
            $i = 0;
            foreach ($ids as $id) {
                $orx->add("fv.resource_id = ?");
                $qb->setParameter($i, $id);
                $i++;
            }
            $qb->where($orx);
            $stmt = $qb->execute();
            foreach ($stmt->fetchAll() as $field) {
                if (!isset($fieldData[$field['resource_id']])) {
                    $fieldData[$field['resource_id']] = [];
                }
                $fieldData[$field['resource_id']][] = $field;
            }

        }

        $qb = $this->db->createQueryBuilder();
        $qb->select('r.*')
                ->from('resources', 'r');
        $orx = $qb->expr()->orX();
        $i = 0;
        foreach ($ids as $id) {
            $orx->add("r.id = ?");
            $qb->setParameter($i, $id);
            $i++;
        }
        $qb->where($orx);
        $stmt = $qb->execute();
        $this['_embedded'] = $this->rebuildResources($stmt->fetchAll(), $fieldData, $fields);
        return $this;
    }

    private function rebuildResources($resources, $fieldData, $fields) {
        $builtResources = [];
        foreach ($resources as $resource) {
            $data = $fieldData[$resource['id']];
            $builtResources[] = $this->rebuildResource($resource, $data, $fields);
        }
        return $builtResources;
    }

    private function rebuildResource($resource, $fieldValues, $fields) {
        foreach ($fields as $field) {
            foreach ($fieldValues as $fieldValue) {
                if ($fieldValue['resource_field_id'] == $field['id']) {
                    $this->allocateValue($resource, $fieldValue, $field);
                    continue;
                }
            }
        }
        return $resource;
    }

    private function allocateValue(&$resource, $fieldValue, $field) {
        if (isset($fieldValue['value'])) {
            $value = $fieldValue['value'];
        } else {
            $mapping = $this->getReadMapping($field['field_type'], $fieldValue);

            $response = $this->resource->get->uri($mapping['uri'])
                ->eager
                ->withQuery($mapping['query'])
                ->request();
            if (isset($response['_model'])) {
                $value = $response[$response['_model']];
            }
        }
        $slug = $field['slug'];
        if ($field['multiple'] != 1) {
            $resource[$slug] = $value;
            return;
        }
        if (!isset($resource[$slug])) {
            $resource[$slug] = [];
        }
        $resource[$slug][] = $value;
    }

}