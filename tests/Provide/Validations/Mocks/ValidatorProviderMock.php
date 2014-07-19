<?php

namespace Mackstar\Spout\Test\Provide\Validations\Mocks;

use Mackstar\Spout\Interfaces\ValidatorProviderInterface;

class ValidatorProviderMock implements ValidatorProviderInterface
{
    public function get()
    {
        return ['emailaddress' => new ValidatorMock];
    }
}
