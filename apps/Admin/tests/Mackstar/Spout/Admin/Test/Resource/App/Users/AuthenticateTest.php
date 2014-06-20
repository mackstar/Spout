<?php

namespace Mackstar\Spout\App\Test\Resource\App\Users;

use Mackstar\Spout\Provide\Session\MockSessionProvider;
use Mackstar\Spout\Tools\Security;
use Ray\Di\Injector;
use Mackstar\Spout\App\Resource\App\Users\Authenticate;
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
            ->withQuery([
                'name' => 'Richard',
                'email' => 'richard.mackstar@gmail.com',
                'password' => 'secret',
                'role' => ['id' => 1]])
            ->eager
            ->request();
    }

    public function tearDown()
    {
        $this->db->exec('DELETE FROM `users` WHERE 1');
    }

    public function testAuthenticatedUser()
    {
        $resource = new Authenticate();
        $resource->setDb($this->db);
        $resource->setSession((new MockSessionProvider())->get());
        $resource->setSecurity(new Security);
        $resource->onPost('richard.mackstar@gmail.com', 'secret');
        $this->assertSame('Richard', $resource->body['user']['name']);
    }
}
