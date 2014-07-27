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
use PDO;

/**
 * FieldTypes
 *
 * @Db
 */
class Listing extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'resources';

    public function onGet(
        $type,
        $sort = 'id',
        $direction = 'ASC',
        $limit = null,
        $offset = null
    )
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select('r.*')
            ->from($this->table, 'r')
            ->where('r.type = :type')
            ->setParameter('type', $type)
            ->orderBy($sort, $direction);

        if (!is_null($limit)) {
            $queryBuilder->setMaxResults($limit);
        }
        if (!is_null($offset)) {
            $queryBuilder->setFirstResult($offset);
        }

        $stmt = $queryBuilder->execute();
        $this['resources'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this;
    }
}
