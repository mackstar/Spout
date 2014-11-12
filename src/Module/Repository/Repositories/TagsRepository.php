<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mackstar\Spout\Module\Repository\Repositories;

use Mackstar\Spout\Module\Repository\RepositoryAbstract;
use Mackstar\Spout\Module\Repository\Interfaces\SearchRepositoryInterface;

class TagsRepository extends RepositoryAbstract implements SearchRepositoryInterface
{
    private $table = 'tags';

    public function search($q) {
        $qb = $this->getQb();
        $qb ->select('t.id', 't.name', 't.slug')
            ->from($this->table, 't')
            ->where('t.slug LIKE :q')
            ->orWhere('t.name LIKE :q')
            ->setParameter('q', "%{$q}%");

        return $qb->execute()->fetchAll();
    }

    public function insertUnique($properties) {

    }
}