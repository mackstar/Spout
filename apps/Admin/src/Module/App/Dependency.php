<?php

namespace Mackstar\Spout\Admin\Module\App;

use Ray\Di\AbstractModule;
use Mackstar\Spout\Module\SecurityModule;
use Mackstar\Spout\Module\StringModule;
use Mackstar\Spout\Provide\Validations\ValidationModule;
use Mackstar\Spout\Provide\Session\SessionModule;
use Mackstar\Spout\Provide\Uuid\UuidModule;

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
        $this->install(new SecurityModule($this));
        $this->install(new StringModule($this));
        $this->install(new ValidationModule($this));
        $this->install(new SessionModule($this));
        $this->install(new UuidModule($this));
    }
}
