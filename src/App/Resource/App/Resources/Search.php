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
use BEAR\Resource\Annotation\Link;
use BEAR\Sunday\Annotation\DbPager;
use PDO;

/**
 * Resources Index
 *
 * @Db
 */
class Search extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'resources';

    /**
     * @Link(rel="type", href="app://spout/entities/types?slug={slug}")
     * @DbPager(5)
     */
    public function onGet($q, $type = null)
    {
        if (strlen($q) < 2) {
            $this['resources'] = [];
            return $this;
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder ->select('r.id', 'r.slug', 'r.title', 'r.type')
            ->from($this->table, 'r')
            ->where('r.slug LIKE :q')
            ->orWhere('r.title LIKE :q')
            ->setParameter('q', "%{$q}%");

        if (!is_null($type)) {
            $queryBuilder->andWhere('r.type = :type')
                ->setParameter(':type', $type);
        }
        $stmt = $queryBuilder->execute();
        $this['resources'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this;
    }
}