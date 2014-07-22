<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\ImageManipulation;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class ImageManipulationModule extends AbstractModule
{
    public function configure()
    {

        $this
            ->bind('Mackstar\Spout\Interfaces\ImageManipulationInterface')
            ->to('Mackstar\Spout\Provide\ImageManipulation\Imagine')
            ->in(Scope::SINGLETON);

    }
}
