<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Module\Repository;

use BEAR\Package;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class RepositoryModule extends AbstractModule
{

    private $repositories = [
        'Tags'
    ];

    protected function configure()
    {
        foreach($this->repositories as $repository) {
            $this->loadRepository($repository);
        }
    }

    private function loadRepository($name) {
        $class = "Mackstar\\Spout\\Module\\Repository\\Repositories\\{$name}Repository";
        $this->bind()
            ->annotatedWith($name . 'Repository')->to($class);
    }

}
