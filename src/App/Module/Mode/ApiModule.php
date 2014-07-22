<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Module\Mode;

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
        $hider = $this->requestInjection('\Mackstar\Spout\App\Interceptor\Users\PasswordHider');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Mackstar\Spout\App\Resource\App\Users\Index'),
            $this->matcher->startsWith('onGet'),
            [$hider]
        );
    }

    private function installModelHeaderAppender()
    {
        $headerAppender = $this->requestInjection('\Mackstar\Spout\App\Interceptor\Tools\ModelHeaderAppender');

        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\ResourceObject'),
            $this->matcher->startsWith('onGet'),
            [$headerAppender]
        );
    }


}
