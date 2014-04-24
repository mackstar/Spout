<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Provide\ImageManipulation;

use Ray\Di\AbstractModule;

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
            ->toProvider('Mackstar\Spout\Provide\ImageManipulationProvider')
            ->in(Scope::SINGLETON);

    }
}