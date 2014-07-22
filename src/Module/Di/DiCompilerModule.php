<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Module\Di;

use Ray\Di\AbstractModule;
use Ray\Di\Di\Scope;

class DiCompilerModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind('Ray\Di\InstanceInterface')
             ->toProvider(__NAMESPACE__ . '\DiCompilerProvider')
             ->in(Scope::SINGLETON);
    }
}