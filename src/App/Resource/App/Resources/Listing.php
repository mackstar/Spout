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
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * FieldTypes
 *
 * @Db
 */
class Listing extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'resources';

    public $links = [];

    protected $listingTable = 'resource_index_listings';

    public function onGet(
        $type,
        $sort = 'id',
        $direction = 'ASC',
        $limit = null,
        $offset = null,
        $fields = null
    )
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('r.*')
            ->from($this->table, 'r')
            ->where("r.type = :type")
            ->setParameter('type', $type);

        if (!in_array($sort, ['title', 'slug', 'created', 'updated', 'id'])) {

            $field = $this->db->createQueryBuilder();
            $field->select('rf.*')
                ->from('resource_fields', 'rf')
                ->where('rf.resource_type = :type')
                ->andWhere('rf.slug = :sort')
                ->setParameter('type', $type)
                ->setParameter('sort', $sort);

            $field = $field->execute()->fetch();
            $fieldTable = 'field_values_' . $field['field_type'];
            $qb->select('r.*, f.value');
            $qb->innerJoin('r', $fieldTable, 'f', 'r.id = f.resource_id');
            $qb->andWhere('f.resource_field_id = :field_id');
            $qb->setParameter('field_id', $field['id']);

            $sort = 'f.value';
        }

        $qb->orderBy($sort, $direction);

        if (!is_null($limit)) {
            $qb->setMaxResults($limit);
        }
        if (!is_null($offset)) {
            $qb->setFirstResult($offset);
        }

        $this['resources'] = $qb->execute()->fetchAll();

        return $this;
    }


}