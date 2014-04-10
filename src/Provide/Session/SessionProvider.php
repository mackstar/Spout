<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Provide\Session;

use Ray\Di\ProviderInterface;
use Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class SessionProvider implements ProviderInterface
{
    public function get()
    {
        $storage = new NativeSessionStorage();
        $session = new Session($storage);
        $session->start();
        return $session;
    }
}

