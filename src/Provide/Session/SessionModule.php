<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mackstar\Spout\Provide\Session;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class SessionModule extends AbstractModule
{
    public function configure()
    {
        $this
            ->bind('Symfony\Component\HttpFoundation\Session')
            ->toProvider('Mackstar\Spout\Provide\Session\SessionProvider')
            ->in(Scope::SINGLETON);
    }
}

