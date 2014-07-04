<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\Resource\Module;

use BEAR\Resource\Adapter\App as AppAdapter;
use BEAR\Resource\Adapter\Http as HttpAdapter;
use BEAR\Resource\Exception\AppName;
use BEAR\Resource\SchemeCollection;
use Ray\Di\ProviderInterface as Provide;
use Ray\Di\InstanceInterface;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * SchemeCollection provider
 */
class SchemeCollectionProvider implements Provide
{
    /**
     * @var string
     */
    protected $apps;

    /**
     * @var InstanceInterface
     */
    protected $injector;

    /**
     * @param string $apps
     *
     * @return void
     *
     * @throws \BEAR\Resource\Exception\AppName
     * @Inject
     * @Named("apps=apps")
     */
    public function setApps($apps)
    {
        $this->apps = $apps;
    }

    /**
     * @param InstanceInterface $injector
     *
     * @Inject
     */
    public function setInjector(InstanceInterface $injector)
    {
        $this->injector = $injector;
    }

    /**
     * Return instance
     *
     * @return SchemeCollection
     */
    public function get()
    {
        $schemeCollection = new SchemeCollection;
        foreach ($this->apps as $host => $app) {
            $this->setNewScheme($schemeCollection, $host, $app);
        }
        $schemeCollection->scheme('http')->host('*')->toAdapter(new HttpAdapter);
        return $schemeCollection;
    }

    /**
     *
     */
    private function setNewScheme(&$schemeCollection, $host, $app) {
        $pageAdapter = new AppAdapter(
            $this->injector,
            $app['namespace'],
            'Resource\Page',
            $app['path'] . '/Page'
        );
        $appAdapter = new AppAdapter(
            $this->injector,
            $app['namespace'],
            'Resource\App',
            $app['path'] . '/App'
        );
        $schemeCollection->scheme('page')->host($host)->toAdapter($pageAdapter);
        $schemeCollection->scheme('app')->host($host)->toAdapter($appAdapter);
    }
}
