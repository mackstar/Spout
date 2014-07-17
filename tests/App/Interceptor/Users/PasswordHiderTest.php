<?php

namespace Mackstar\Spout\Test\App\Interceptor\Users;

use Mackstar\Spout\App\Interceptor\Users\PasswordHider;
use Mackstar\Spout\App\Test\Interceptor\Users\Mocks\UserIndexMock;
use Ray\Aop\ReflectiveMethodInvocation;

class PasswordHiderTest extends \PHPUnit_Framework_TestCase
{

    public function testHidesPasswordsForSingleUser()
    {
        $interceptor = new PasswordHider;
        $target = array(new \Mackstar\Spout\Test\App\Interceptor\Users\Mocks\UserIndexMock, 'onGet');
        $invocation = new ReflectiveMethodInvocation($target, [], [$interceptor]);
        $result = $interceptor->invoke($invocation);

        $this->assertFalse(isset($result->body['user']['password']));
        $this->assertTrue(isset($result->body['user']['name']));
    }

    public function testHidesPasswordsForMultipleUsers()
    {
        $interceptor = new PasswordHider;
        $target = array(new \Mackstar\Spout\Test\App\Interceptor\Users\Mocks\UserIndexMock, 'onGet');
        $invocation = new ReflectiveMethodInvocation($target, [], [$interceptor]);
        $result = $interceptor->invoke($invocation);

        $this->assertFalse(isset($result->body['users'][0]['password']));
        $this->assertTrue(isset($result->body['users'][0]['name']));
    }
}
