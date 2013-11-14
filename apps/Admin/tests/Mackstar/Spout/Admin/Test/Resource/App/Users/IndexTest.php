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
        $page = $this->resource->get->uri('app://self/users/index')
            ->withQuery(['email' => 'richard.mackstar@gmail.com'])
            ->eager
            ->request();

        $this->assertSame('Richard', $page->body['users'][0]['name']);
    }
}
