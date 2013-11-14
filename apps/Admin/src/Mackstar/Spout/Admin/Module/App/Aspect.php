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
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
    	$this->installPasswordEncryptor();
    }

    private function installPasswordEncryptor()
    {
        // bind tmp writable checker
        // $encryptor = $this->requestInjection('\Mackstar\Spout\Admin\Interceptor\Users\PasswordEncryptor');
        // $this->bindInterceptor(
        //     $this->matcher->subclassesOf('Mackstar\Spout\Admin\Resource\App\Users\Index'),
        //     $this->matcher->startWith('onPost'),
        //     [$encryptor]
        // );
    }
}
