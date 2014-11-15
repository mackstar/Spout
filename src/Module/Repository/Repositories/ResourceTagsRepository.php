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
use Mackstar\Spout\Module\Repository\Interfaces\ManyToManyJoinRepositoryInterface;

class ResourceTagsRepository extends RepositoryAbstract implements ManyToManyJoinRepositoryInterface
{
    private $table = 'resource_tags';
    private $tagsTable = 'tags';
    private $resourceTable = 'resources';

    public function join($resourceId, $tagId) {
        $this->db->insert($this->table, [
            'tag_id' => $tagId,
            'resource_id' => $resourceId
        ]);
    }

    public function delete($resourceId) {
        $this->db->delete($this->table, [
            'resource_id' => $resourceId
        ]);
    }

    public function clearOrphans() {
        $this->db->exec(
            "DELETE {$this->tagsTable} " .
            "FROM {$this->tagsTable} " .  
            "LEFT JOIN {$this->table} " .
            "ON {$this->tagsTable}.id = {$this->table}.tag_id " .
            "WHERE {$this->table}.tag_id IS NULL"
        );
    }

    public function getTags($resourceId) {
        $qb = $this->getQb();
        $qb->select('t.id', 't.name', 't.slug')
            ->from($this->tagsTable, 't')
            ->innerJoin('t', $this->table, 'rt', 't.id = rt.tag_id')
            ->where('rt.resource_id = :resource')
            ->setParameter(':resource', $resourceId);
        return $qb->execute()->fetchAll();
    }
}