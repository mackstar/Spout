<?php
/**
 * This file is part of the Mackstar.SpoutSite package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mackstar\Spout\Test\Module\Repository\Repositories\Mocks;

use Mackstar\Spout\Module\Repository\Repositories\TagsRepository;

class TagsRepositoryMock extends TagsRepository
{
    protected $qb;

    public function setQb($qb) {
        $this->qb = $qb;
    }

    protected function getQb() {
        return $this->qb;
    }
}