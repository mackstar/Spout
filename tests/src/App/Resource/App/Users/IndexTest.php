<?php

namespace Mackstar\Spout\Test\App\Resource\App\Users;

use Mackstar\Spout\Tools\Security;
use Ray\Di\Injector;
use Admin\Module\TestModule;
use Mackstar\Spout\App\Resource\App\Users\Index;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    private $db;

    protected function setUp()
    {
        parent::setUp();
        $this->db = clone $GLOBALS['DB'];
        $this->resource = clone $GLOBALS['RESOURCE'];
    }

    public static function tearDownAfterClass()
    {
        $GLOBALS['DB']->exec('DELETE FROM `users` WHERE 1');
    }

    /**
     * @test
     */
    public function postUser()
    {
        // resource request
        $resource = new Index;
        $resource->setDb($this->db);
        $resource->setSecurity(new Security());
        $resource->onPost('richard.mackstar@gmail.com', 'Richard', ['id' => 1], 'secret');
        $this->assertSame(200, $resource->code);
    }

    /**
     * @depends postUser
     */
    public function testGetPostedUser()
    {
        // resource request
        $resource = $this->resource->get->uri('app://spout/users/index')
            ->eager
            ->request();

        $this->assertSame('Richard', $resource->body['users'][0]['name']);
    }

    /**
     * @depends postUser
     */
    public function testGetPostedUserWithEmailQuery()
    {
        // resource request
        $resource = $this->resource->get->uri('app://spout/users/index')
            ->withQuery(['email' => 'richard.mackstar@gmail.com'])
            ->eager
            ->request();

        $this->assertSame('Richard', $resource->body['user']['name']);
    }
}
