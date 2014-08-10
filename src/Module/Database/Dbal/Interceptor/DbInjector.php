<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Module\Database\Dbal\Interceptor;

use Doctrine\Common\Annotations\AnnotationReader as Reader;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Logging\SQLLogger;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

final class DbInjector implements MethodInterceptor
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var DebugStack
     */
    private $sqlLogger;

    /**
     * DSN for master
     *
     * @var array
     */
    private $masterDb;

    /**
     * DSN for slave
     *
     * @var array
     */
    private $slaveDb;

    /**
     * Pager DB connection class
     *
     * @var string
     */
    private $pagerClass = 'BEAR\Package\Module\Database\Dbal\PagerConnection';

    /**
     * @param $pagerClass
     *
     * @Inject(optional = true)
     * @Named("pager_class")
     */
    public function setPagerClass($pagerClass)
    {
        $this->pagerClass = $pagerClass;
    }

    /**
     * @param array $masterDb
     * @param array $slaveDb
     *
     * @Inject
     * @Named("masterDb=master_db,slaveDb=slave_db")
     */
    public function __construct(array $masterDb, array $slaveDb)
    {
        $this->masterDb = $masterDb;
        $this->slaveDb = $slaveDb;
    }

    /**
     * Set annotation reader
     *
     * @param Reader $reader
     *
     * @return void
     * @Inject
     */
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Set SqlLogger
     *
     * @param \Doctrine\DBAL\Logging\SQLLogger $sqlLogger
     *
     * @Inject(optional = true)
     */
    public function setSqlLogger(SQLLogger $sqlLogger)
    {
        $this->sqlLogger = $sqlLogger;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $object = $invocation->getThis();
        $method = $invocation->getMethod();
        $write = ['onPut', 'onDelete', 'onPost'];
        $connectionParams = (in_array($method->name, $write))?  $this->masterDb : $this->slaveDb;
        $pagerAnnotation = $this->reader->getMethodAnnotation($method, 'BEAR\Sunday\Annotation\DbPager');
        $db = $this->getDb($pagerAnnotation, $connectionParams);

        /* @var $db \BEAR\Package\Module\Database\Dbal\PagerConnection */

        if ($this->sqlLogger instanceof SQLLogger) {
            $db->getConfiguration()->setSQLLogger($this->sqlLogger);
        }
        $object->setDb($db);
        $result = $invocation->proceed();
        if ($this->sqlLogger instanceof DebugStack) {
            $this->sqlLogger->stopQuery();
            $object->headers['x-sql'] = [$this->sqlLogger->queries];
        } elseif ($this->sqlLogger instanceof SQLLogger) {
            $this->sqlLogger->stopQuery();
        }
        if (!$pagerAnnotation) {
            return $result;
        }
        $pagerData = $db->getPager();
        if ($pagerData) {
            $object->headers['pager'] = $pagerData;
        }

        return $result;
    }

    /**
     * @param       $pagerAnnotation
     * @param array $connectionParams
     *
     * @return \BEAR\Package\Module\Database\Dbal\PagerConnection|\Doctrine\DBAL\Connection
     */
    private function getDb($pagerAnnotation, array $connectionParams)
    {
        if (!$pagerAnnotation) {
            return DriverManager::getConnection($connectionParams);
        }

        $connectionParams['wrapperClass'] = $this->pagerClass;
        $db = DriverManager::getConnection($connectionParams);
        /** @var $db \BEAR\Package\Module\Database\Dbal\PagerConnection */
        $db->setMaxPerPage($pagerAnnotation->limit);

        return $db;
    }
}
