<?php

namespace Mackstar\Spout\Provide\Validations;

use Mackstar\Spout\Provide\Validations\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    private $validator;

    public function setUp()
    {
        $provider = new Mocks\ValidatorProviderMock;
        $this->validator = new Validator($provider);
    }

    public function testInstatiationOfValidatorClass()
    {
        $this->assertInstanceOf('Mackstar\Spout\Provide\Validations\Validator', $this->validator);
    }

    public function testCorrectInstanceIsReturnedByGetMethod()
    {
        $result = $this->validator->get('emailaddress');
        $this->assertInstanceOf('Mackstar\Spout\Provide\Validations\Mocks\ValidatorMock', $result);
    }

    public function testMessagesAreReturnedFromCurrentValidator()
    {
        $emailValidator = $this->validator->get('emailaddress');
        $result = $this->validator->getMessages();
        $expected = [
            'This is message1',
            'This another message'
        ];
        $this->assertEquals($result, $expected);
    }
}
