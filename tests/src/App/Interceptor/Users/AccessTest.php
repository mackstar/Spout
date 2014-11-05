<?php

namespace Mackstar\Spout\Test\App\Interceptor\Users;


use Mackstar\Spout\Test\App\Interceptor\Users\Mocks\UserIndexMock;
use Mackstar\Spout\App\Interceptor\Users\Access;
use Ray\Aop\ReflectiveMethodInvocation;

class AccessTest extends \PHPUnit_Framework_TestCase
{

    public function testAllowsAccessFor() {
        // $interceptor = new Access;
        // $interceptor->setSession();
        // $user = new UserIndexMock;
        // $target = [$user, 'onGet'];
        // $invocation = new ReflectiveMethodInvocation($target, [], [$interceptor]);
        // $result = $interceptor->invoke($invocation);
    }
}
