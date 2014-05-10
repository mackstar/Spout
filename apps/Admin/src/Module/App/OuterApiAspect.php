<?php

namespace Mackstar\Spout\Admin\Module\App;

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
        $pagerAppender = $this->requestInjection('\Mackstar\Spout\Admin\Interceptor\Tools\PagerAppender');

        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\ResourceObject'),
            $this->matcher->startWith('onGet'),
            [$pagerAppender]
        );
    }
}
