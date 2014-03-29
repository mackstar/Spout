<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Provide\Validations;

use Ray\Di\AbstractModule;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class ValidationModule extends AbstractModule
{
    public function configure()
    {
        $this
            ->bind('Mackstar\Spout\Interfaces\ValidatorProviderInterface')
            ->to('Mackstar\Spout\Provide\Validations\ValidatorProvider');

        $this
            ->bind('Mackstar\Spout\Interfaces\ValidatorInterface')
            ->to('Mackstar\Spout\Provide\Validations\Validator');
    }
}
