<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
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
