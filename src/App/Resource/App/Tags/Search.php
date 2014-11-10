<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Tags;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use PDO;

/**
 * FieldTypes
 *
 * @Db
 */
class Search extends ResourceObject
{

    use DbSetterTrait;

    private $table = 'tags';

    public function onGet($q)
    {
        if (strlen($q) < 2) {
            $this['resources'] = [];
            return $this;
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder ->select('t.id', 't.name', 't.slug as text')
            ->from($this->table, 't')
            ->where('t.slug LIKE :q')
            ->orWhere('t.name LIKE :q')
            ->setParameter('q', "%{$q}%");

        $stmt = $queryBuilder->execute();
        $this['tags'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this;
    }
}