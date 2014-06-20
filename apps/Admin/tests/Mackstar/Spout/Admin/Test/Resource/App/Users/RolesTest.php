<?php

namespace Mackstar\Spout\App\Test\Resource\App\Users;

use Ray\Di\Injector;
use Admin\Module\TestModule;

class RolesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = clone $GLOBALS['RESOURCE'];
    }

    /**
     * @test
     */
    public function getRoles()
    {
        // resource request
        $page = $this->resource->get->uri('app://self/users/roles')
            ->eager
            ->request();
        $this->assertSame(5, count($page->body['roles']));
    }
}
