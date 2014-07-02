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
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;


/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class MockSessionProvider implements ProviderInterface
{
    public function get()
    {
        $storage = new MockArraySessionStorage();
        $session = new Session($storage);
        $session->start();
        return $session;
    }
}
