<?php

namespace Mackstar\Spout\Admin\Module\App;

use BEAR\Package;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

use Mackstar\Spout\Admin\Interceptor\Validators\UserValidator;

/**
 * Application Aspect
 */
class Aspect extends AbstractModule
{

    protected function configure()
    {
    	$this->installFormValidators();
    }

    private function installFormValidators()
    {
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Mackstar\Spout\Admin\Resource\App\Users\Index'),
       	    $this->matcher->annotatedWith('Mackstar\Spout\Admin\Annotation\Form'),
            [new UserValidator]
        );
    }
}
