<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Module;

use Ray\Di\AbstractModule;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class StringModule extends AbstractModule
{
    public function configure()
    {
        $this
            ->bind('Mackstar\Spout\Interfaces\StringInterface')
            ->to('Mackstar\Spout\Tools\String');
    }
}
