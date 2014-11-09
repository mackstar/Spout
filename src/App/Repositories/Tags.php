<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mackstar\Spout\App\Repositories;

use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use PDO;

/**
 * @Db
 */
class Tags
{
    use DbSetterTrait;

    protected $table = 'tags';

    public function search($q)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder ->select('t.id', 't.name', 't.slug as text')
            ->from($this->table, 't')
            ->where('t.slug LIKE :q')
            ->orWhere('t.name LIKE :q')
            ->setParameter('q', "%{$q}%");

        $stmt = $queryBuilder->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}