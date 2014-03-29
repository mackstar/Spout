<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
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

