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

class Mediaupload extends ResourceObject
{

    public $code = 500;

    public $body = [
        'title' => 'Media Upload Error',
        'message' => 'The media was either too large or of the wrong type.'
    ];

    public function onGet()
    {
        return $this;
    }
}
