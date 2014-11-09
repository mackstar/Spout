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
class RepositoryModule extends AbstractModule
{

    protected function configure()
    {

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

}
