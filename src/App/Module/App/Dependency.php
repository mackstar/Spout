<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Module\App;

use Ray\Di\AbstractModule;
use Mackstar\Spout\Module\SecurityModule;
use Mackstar\Spout\Module\StringModule;
use Mackstar\Spout\Provide\Validations\ValidationModule;
use Mackstar\Spout\Provide\Session\SessionModule;
use Mackstar\Spout\Provide\Uuid\UuidModule;
use Mackstar\Spout\Provide\ImageManipulation\ImageManipulationModule;
use Mackstar\Spout\Module\Repository\RepositoryModule;


/**
 * Application Dependency
 */
class Dependency extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new RepositoryModule($this));
        $this->install(new SecurityModule($this));
        $this->install(new StringModule($this));
        $this->install(new ValidationModule($this));
        $this->install(new SessionModule($this));
        $this->install(new UuidModule($this));
        $this->install(new ImageManipulationModule($this));
    }
}
