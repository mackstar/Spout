<?php

namespace Mackstar\Spout\Admin\Test\Interceptor\Validators;

use Mackstar\Spout\Admin\Interceptor\Validators\UserValidator;
use Mackstar\Spout\Provide\Validations\Validator;
use Ray\Aop\ReflectiveMethodInvocation;

class UserValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testHidesPasswordsForSingleUser()
    {
        $interceptor = new UserValidator;
        $interceptor->setValidator(new Validator);
        $interceptor->setResource(clone $GLOBALS['RESOURCE']);

        $target = array(new \Mackstar\Spout\Admin\Resource\App\Users\Index, 'onPost');
        $args = ['','','',''];
        $invocation = new ReflectiveMethodInvocation($target, $args, [$interceptor]);
        $result = $interceptor->invoke($invocation);
        $this->assertEquals($result->code, 400);
        $this->assertTrue(isset($result->body['errors']['email']));
    }


}
