<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Indexes;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use PDO;

/**
 * FieldTypes
 *
 * @Db
 */
class Uris extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'index_uris';

    public function onGet(
        $index
    )
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select('u.*')
            ->from($this->table, 'u')
            ->where('u.index = :index')
            ->setParameter('index', $index);

        $stmt = $queryBuilder->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $uris = [];
        foreach($result as $record) {
            if (!isset($uris[$record['key']])) {
                $uris[$record['key']] = [];
            }
            $uris[$record['key']][] = $record;
        }
        $this['uris'] = $uris;

        return $this;
    }

    public function onPost(
        $index,
        $uri,
        $key
    )
    {
        $this->db->insert($this->table, [
            'index' => $index,
            'uri' => $uri,
            'key' => $key
        ]);

        return $this;
    }


}



