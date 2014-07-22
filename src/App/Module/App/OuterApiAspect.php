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
 * Outer API Aspect
 */
class OuterApiAspect extends AbstractModule
{

    protected function configure()
    {
        $this->installPagerAppender();
    }

    private function installPagerAppender()
    {
        $pagerAppender = $this->requestInjection('\Mackstar\Spout\App\Interceptor\Tools\PagerAppender');

        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\ResourceObject'),
            $this->matcher->startsWith('onGet'),
            [$pagerAppender]
        );
    }
}
