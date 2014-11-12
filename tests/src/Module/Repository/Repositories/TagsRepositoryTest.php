<?php
/**
 * This file is part of the Mackstar.SpoutSite package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mackstar\Spout\Test\Module\Repository\Repositories;

use Mackstar\Spout\Test\Module\Repository\Repositories\Mocks\TagsRepositoryMock;
use Mackstar\Spout\Test\Module\Repository\Mocks\QueryBuilderMock;

class TagsRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $tags;
    private $qb;

    protected function setUp()
    {
        $this->tags = new TagsRepositoryMock();
        $this->qb = new QueryBuilderMock();
        $this->tags->setQb($this->qb);
    }

    public function testSearchQuery()
    {
        $this->tags->search("something");
        $this->assertEquals($this->qb->from[0], 'tags');
        $this->assertEquals($this->qb->setParameter[1], '%something%');
    }
}