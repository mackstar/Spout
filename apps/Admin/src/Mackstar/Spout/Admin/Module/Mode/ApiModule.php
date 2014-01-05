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
        $this->installPasswordEncryptor();
        $this->installModelHeaderAppender();
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

    private function installModelHeaderAppender()
    {
        $headerAppender = $this->requestInjection('\Mackstar\Spout\Admin\Interceptor\Tools\ModelHeaderAppender');

        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\ResourceObject'),
            $this->matcher->startWith('onGet'),
            [$headerAppender]
        );
    }
}
