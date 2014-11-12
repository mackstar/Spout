<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Module\Database\Dbal;

use Ray\Di\AbstractModule;

class DbalModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // @Db
        $this->installDbInjector();
        // @Transactional
        $this->installTransaction();
        // @Time
        $this->installTimeStamper();
    }

    /**
     * @Db - db setter
     */
    private function installDbInjector()
    {
        $dbInjector = $this->requestInjection(__NAMESPACE__ . '\Interceptor\DbInjector');
        $this->bindInterceptor(
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Db'),
            $this->matcher->startsWith('on'),
            [$dbInjector]
        );

        $this->bindInterceptor(
            $this->matcher->subclassesOf('Mackstar\Spout\Module\Repository\RepositoryAbstract'),
            $this->matcher->logicalNot($this->matcher->startsWith('setDb')),
            [$dbInjector]
        );

        $this->bindInterceptor(
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Db'),
            $this->matcher->startsWith('invoke'),
            [$dbInjector]
        );
    }

    /**
     * @Transactional - db transaction
     */
    private function installTransaction()
    {
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Transactional'),
            [$this->requestInjection('BEAR\Package\Module\Database\Dbal\Interceptor\Transactional')]
        );
    }

    /**
     * @Time - put time to 'time' property
     */
    private function installTimeStamper()
    {
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Time'),
            [$this->requestInjection('BEAR\Package\Module\Database\Dbal\Interceptor\TimeStamper')]
        );
    }
}
