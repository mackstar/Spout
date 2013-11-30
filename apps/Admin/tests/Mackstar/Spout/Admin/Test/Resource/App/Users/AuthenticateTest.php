<?php

namespace Mackstar\Spout\Admin\Test\Resource\App\Users;

use Ray\Di\Injector;
use Admin\Module\TestModule;

class AuthenticateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    private $db;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = clone $GLOBALS['RESOURCE'];
        $this->db = clone $GLOBALS['DB'];
        $this->resource->post->uri('app://self/users/index')
            ->withQuery(['name' => 'Richard', 'email' => 'richard.mackstar@gmail.com', 'password' => 'secret'])
            ->eager
            ->request();
    }

    public function tearDown()
    {
        $this->db->exec('DELETE FROM `users` WHERE 1');
    }

    public function testAuthenticatedUser()
    {
        $resource = $this->resource->post->uri('app://self/users/authenticate')
        	->withQuery(['email' => 'richard.mackstar@gmail.com', 'password' => 'secret'])
            ->eager
            ->request();
        $this->assertSame('Richard', $resource->body['user']['name']);
    }
}
