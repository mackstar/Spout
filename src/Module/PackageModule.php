<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Mackstar\Spout\Module;

use BEAR\Package\Module as Package;
use BEAR\Package\Provide as Provide;
use BEAR\Sunday\Module as Sunday;
use BEAR\Resource\Module as Resource;
use BEAR\Package\Dev\Module as DevPackage;
use Ray\Di\AbstractModule;
use Ray\Di\Di\Scope;

class PackageModule extends AbstractModule
{
    /**
     * @var array config
     */
    private $config;

    /**
     * @var string Application class name
     */
    private $appClass;

    /**
     * @var string
     */
    private $context;

    /**
     * @param string $appClass
     * @param string $context
     * @param array  $config
     */
    public function __construct($appClass, $context, array $config)
    {
        $this->appClass = $appClass;
        $this->context = $context;
        $this->config = $config;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind('BEAR\Sunday\Extension\Application\AppInterface')->to($this->appClass)->in(Scope::SINGLETON);
        // Sunday Module
        $constants = [
            'package_dir' => dirname(dirname(dirname(__DIR__))),
            'app_context' => $this->context
        ];
        $this->install(new Sunday\Constant\NamedModule($constants + $this->config));
        $this->install(new Sunday\Cache\CacheModule);
        $this->install(new Sunday\Code\CachedAnnotationModule($this));

        // Package Module
        $this->install(new Package\Cache\CacheAspectModule($this));
        $this->install(new \Mackstar\Spout\Module\Di\DiCompilerModule($this));
        $this->install(new Package\Di\DiModule($this));
        $this->install(new DevPackage\ExceptionHandle\ExceptionHandleModule);

        // Mackstar Spout Resource Package
        $this->install(
            new \Mackstar\Spout\Provide\Resource\Module\ResourceModule(
                $this->config['app_name'], $this->config['resource_dir']
            )
        );

        // Resource Module
        //$this->install(new Resource\EmbedResourceModule($this));

        // Provide module (BEAR.Sunday extension interfaces)
        $this->install(new Provide\WebResponse\HttpFoundationModule);
        $this->install(new Provide\ConsoleOutput\ConsoleOutputModule);
        //$this->install(new Provide\Router\WebRouterModule);
        $this->install(new \Mackstar\Spout\Provide\ResourceView\TemplateEngineRendererModule);
        $this->install(new Provide\ResourceView\HalModule);

        // Contextual Binding
        if ($this->context === 'test') {
            $this->install(new Package\Resource\NullCacheModule($this));
        }
        if ($this->context === 'dev') {
            $this->install(new Provide\ApplicationLogger\ApplicationLoggerModule);
            $this->install(new Package\Resource\DevResourceModule($this));
            $this->install(new Provide\ApplicationLogger\DevApplicationLoggerModule($this));
        }
        $this->install(new Package\Database\Dbal\DbalModule($this));
        if ($this->context === 'prod') {
            $this->install(new Package\Cache\CacheAspectModule($this));
        }
    }
}
