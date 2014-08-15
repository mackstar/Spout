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
        $this->installUserSessionAppender();
        $this->installInjectUserId();
        $this->installModelHeaderAppender();
    }

    private function installFormValidators()
    {
        $this->requestInjection('Mackstar\Spout\Provide\Validations\Validator');
        $userValidator = $this->requestInjection('Mackstar\Spout\App\Interceptor\Validators\UserValidator');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('Mackstar\Spout\App\Resource\App\Users\Index'),
            $this->matcher->annotatedWith('Mackstar\Spout\App\Annotation\Form'),
            [$userValidator]
        );
    }

    private function installInjectUserId()
    {
        $injectUserId = $this->requestInjection('\Mackstar\Spout\App\Interceptor\Users\InjectUserId');

        $this->bindInterceptor(
            $this->matcher->annotatedWith('Mackstar\Spout\App\Annotation\UserIdInject'),
            $this->matcher->startWith('on'),
            [$injectUserId]
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

    private function installUserSessionAppender()
    {
        $session = $this->requestInjection('\Mackstar\Spout\App\Interceptor\Users\Session');

        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\ResourceObject'),
            $this->matcher->startsWith('onGet'),
            [$session]
        );
    }
}
