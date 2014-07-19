<?php

namespace Mackstar\Spout\Test\Provide\Validations;

use Mackstar\Spout\Provide\Validations\ValidatorProvider;

class ValidatorProviderTest extends \PHPUnit_Framework_TestCase
{

    private $validator;

    public function setUp()
    {
        $provider = new ValidatorProvider;
        $this->validator = $provider->get();
    }

    public function testProvidesAnArrayOfValidations()
    {
        $this->assertTrue(is_array($this->validator));
        $this->assertArrayHasKey('emailaddress', $this->validator);
    }

    public function testProvidedValidatorsAreInitialised()
    {
        $this->assertTrue(is_object($this->validator['emailaddress']));
    }
}
