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

class ResourcesRepository extends RepositoryAbstract
{
    private $table = 'resources';

    public function getById($id) {
        $qb = $this->getQb();
        $qb ->select('r.*')
            ->from($this->table, 'r')
            ->where('r.id = :id')
            ->setParameter('id', $id);
        return $qb->execute()->fetch();
    }
}