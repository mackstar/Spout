<?php

namespace Mackstar\Spout\Admin\Resource\App\Exceptions;

use BEAR\Resource\ResourceObject;

class Validation extends ResourceObject{

    public $code = 400;

    public $body = [
        'errors' => []
    ];

    public function onGet($errors = null)
    {
        $this['errors'] = $errors;
        return $this;
    }
}