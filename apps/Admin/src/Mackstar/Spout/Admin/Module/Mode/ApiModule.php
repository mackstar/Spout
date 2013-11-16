<?php

namespace Mackstar\Spout\Admin\Module\Mode;

use BEAR\Package\Module as PackageModule;
use BEAR\Sunday\Module as SundayModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class ApiModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
    }

    private function installPasswordEncryptor()
    {
        // bind tmp writable checker
        $hider = $this->requestInjection('\Mackstar\Spout\Admin\Interceptor\Users\PasswordHider');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Mackstar\Spout\Admin\Resource\App\Users\Index'),
            $this->matcher->startWith('onGet'),
            [$hider]
        );
    }
}
