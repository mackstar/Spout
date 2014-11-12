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
use Mackstar\Spout\Module\Repository\RepositoryAbstract;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class Search extends ResourceObject
{

    private $tagsRepository;

    /**
     * @Inject
     * @Named("repository=TagsRepository")
     */
    public function setTagsRepository($repository) {
        $this->tagsRepository = $repository;
    }


    public function onGet($q)
    {
        $this['tags'] = (strlen($q) < 2)? [] : $this->tagsRepository->search($q);
        return $this;
    }
}