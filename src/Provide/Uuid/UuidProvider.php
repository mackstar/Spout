<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\Uuid;

use Ray\Di\ProviderInterface;
use Rhumsaa\Uuid\Uuid;

class UuidProvider implements ProviderInterface
{
    public function get()
    {
        return Uuid::uuid4();
    }
}
