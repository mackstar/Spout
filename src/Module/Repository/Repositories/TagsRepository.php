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
use Cocur\Slugify\SlugifyInterface;
use Ray\Di\Di\Inject;

class TagsRepository extends RepositoryAbstract implements SearchRepositoryInterface
{
    private $table = 'tags';
    private $slugify;

    /**
     * @Inject
     */
    public function setSlugify(SlugifyInterface $slugify) {
        $this->slugify = $slugify;
    }

    public function search($q) {
        $qb = $this->getQb();
        $qb ->select('t.id', 't.name', 't.slug')
            ->from($this->table, 't')
            ->where('t.slug LIKE :q')
            ->orWhere('t.name LIKE :q')
            ->setParameter('q', "%{$q}%");

        return $qb->execute()->fetchAll();
    }

    public function insert($properties) {
        if (isset($properties['id'])) {
            return $properties['id'];
        }
        $slug = $this->slugify->slugify($properties['name']);
        if ($result = $this->get($slug)) {
            return $result['id'];
        }
        $this->db->insert($this->table, [
            'slug' => $slug,
            'name' => $properties['name']
        ]);
        return $this->db->lastInsertId();
    }

    public function get($slug) {
        $qb = $this->getQb();
        $qb ->select('t.id')
            ->from($this->table, 't')
            ->where('t.slug = :slug')
            ->setParameter('slug', $slug);
        return $qb->execute()->fetch();
    }
}