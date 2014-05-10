<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */

namespace Mackstar\Spout\Provide\Uuid;

use Ray\Di\AbstractModule;

class UuidModule extends AbstractModule
{

    public function configure()
    {
        $this
            ->bind('Rhumsaa\Uuid\Uuid')
            ->toProvider('Mackstar\Spout\Provide\Uuid\UuidProvider');
    }

}
