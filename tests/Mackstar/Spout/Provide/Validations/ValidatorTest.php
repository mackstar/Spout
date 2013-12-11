<?php

namespace Mackstar\Spout\Provide\Validations;

use Mackstar\Spout\Provide\Validations\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInstatiationOfValidatorClass()
    {
        $provider = new Mocks\ValidatorProviderMock;
        $validator = new Validator($provider);
        $this->assertInstanceOf('Mackstar\Spout\Provide\Validations\Validator', $validator);
    }
}