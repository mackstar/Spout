<?php
namespace Mackstar\Spout\Admin\Test\Resource\App\Users;

use Ray\Di\Injector;
use Admin\Module\TestModule;

class IndexTest extends \PHPUnit_Framework_TestCase
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
        $page = $this->resource->post->uri('app://self/users/index')
            ->withQuery(['name' => 'Richard', 'email' => 'richard.mackstar@gmail.com', 'password' => 'secret'])
            ->eager
            ->request();
        $this->assertSame(200, $page->code);
    }

    /**
     * @depends postUser
     */
    public function testGetPostedUser()
    {
        // resource request
        $resource = $this->resource->get->uri('app://self/users/index')
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
        $resource = $this->resource->get->uri('app://self/users/index')
            ->withQuery(['email' => 'richard.mackstar@gmail.com'])
            ->eager
            ->request();

        $this->assertSame('Richard', $resource->body['user']['name']);
    }
}
