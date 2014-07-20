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

use Ray\Di\ProviderInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;


/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class SessionProvider implements ProviderInterface
{

    /**
     * @param string $context
     *
     * @Inject
     * @Named("app_context")
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    public function get()
    {
        $storage = new NativeSessionStorage();
        $session = new Session($storage);
        $session->start();
        return $session;
    }
}
