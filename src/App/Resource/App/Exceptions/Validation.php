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
