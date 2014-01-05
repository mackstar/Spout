<?php

namespace Mackstar\Spout\Admin\Module\App;

use Ray\Di\AbstractModule;
use Mackstar\Spout\Module\SecurityModule;
use Mackstar\Spout\Module\StringModule;
use Mackstar\Spout\Provide\Validations\ValidationModule;


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
    }
}
