<?php

namespace Mackstar\Spout\Admin\Module\App;

use BEAR\Package;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

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
        $this->requestInjection('Mackstar\Spout\Provide\Validations\Validator');
        $userValidator = $this->requestInjection('Mackstar\Spout\Admin\Interceptor\Validators\UserValidator');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Mackstar\Spout\Admin\Resource\App\Users\Index'),
       	    $this->matcher->annotatedWith('Mackstar\Spout\Admin\Annotation\Form'),
            [$userValidator]
        );
    }
}
