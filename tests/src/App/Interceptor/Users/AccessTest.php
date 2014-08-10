<?php

namespace Mackstar\Spout\Test\App\Interceptor\Users;


use Mackstar\Spout\App\Test\Interceptor\Users\Mocks\UserIndexMock;
use Ray\Aop\ReflectiveMethodInvocation;

class AccessTest extends \PHPUnit_Framework_TestCase
{

    public function testAllowsAccessFor
        $interceptor = new Access;
        $user = new UserIndexMock;
        $target = [$user, 'onGet'];
        $invocation = new ReflectiveMethodInvocation($target, [], [$interceptor]);
        $result = $interceptor->invoke($invocation);

        var_dump($result);
        exit;

        
    }
}
