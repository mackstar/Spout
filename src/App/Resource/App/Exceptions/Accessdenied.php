<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Exceptions;

use BEAR\Resource\ResourceObject;

class Accessdenied extends ResourceObject
{

    public $code = 401;

    public $body = [
        'title' => 'Oops!',
        'message' => 'You are not authorised to access this page',
        'errors' => []
    ];

    public function onGet($errors = [])
    {
        $this['errors'] = $errors;
        return $this;
    }
}