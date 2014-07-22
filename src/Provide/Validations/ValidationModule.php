<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
