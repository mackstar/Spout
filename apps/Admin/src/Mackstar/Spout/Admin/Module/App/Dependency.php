<?php

namespace Mackstar\Spout\Admin\Module\App;

use Ray\Di\AbstractModule;
use Mackstar\Spout\Module\SecurityModule;


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
    }
}
