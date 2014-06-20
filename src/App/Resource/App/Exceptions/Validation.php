<?php

namespace Mackstar\Spout\App\Resource\App\Exceptions;

use BEAR\Resource\ResourceObject;

class Validation extends ResourceObject
{

    public $code = 400;

    public $body = [
        'title' => 'Oops!',
        'message' => 'It seems you didn\'t enter everything correctly',
        'errors' => []
    ];

    public function onGet($errors = null)
    {
        $this['errors'] = $errors;
        return $this;
    }
}
