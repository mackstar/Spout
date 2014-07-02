<?php
/**
 * This file is part of the Mackstar.Spout package.
 * 
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\Router;

use Ray\Di\AbstractModule;

class Module extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind('BEAR\Sunday\Extension\Router\RouterInterface')->to('Mackstar\Spout\Provide\Router\Router');
        $this->bind('BEAR\Package\Provide\Router\Adapter\AdapterInterface')->to('Mackstar\Spout\Provide\Router\AuraRouter');
    }
}
