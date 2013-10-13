<?php

namespace Skeleton\Module;

use BEAR\Package\Module\Form\AuraForm\AuraFormModule;
use BEAR\Package\Module\Package\PackageModule;
use BEAR\Package\Module\Resource\ResourceGraphModule;
use BEAR\Package\Module\Resource\SignalParamModule;
use BEAR\Package\Module\Stub\StubModule;
use BEAR\Package\Provide as ProvideModule;
use BEAR\Package\Provide\ResourceView;
use BEAR\Package\Provide\ResourceView\HalModule;
use BEAR\Package\Provide\TemplateEngine\Smarty\SmartyModule;
use BEAR\Sunday\Module as SundayModule;
use BEAR\Sunday\Module\Constant\NamedModule as Constant;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Skeleton\Module\Mode\DevModule;

/**
 * Application module
 */
class AppModule extends AbstractModule
{
    /**
     * Constants
     *
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $context;

    /**
     * @param string $context
     *
     * @throws \LogicException
     */
    public function __construct($context = 'prod')
    {
        $dir = __DIR__;
        $this->context = $context;
        $this->config = (require "{$dir}/config/{$context}.php") + (require "{$dir}/config/prod.php");
        $this->params = (require "{$dir}/config/params/{$context}.php") + (require "{$dir}/config/params/prod.php");
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // install core package
        $this->install(new PackageModule(new Constant($this->config), 'Skeleton\App', $this->context));

        // install view package
        $this->install(new SmartyModule($this));
        //$this->install(new TwigModule($this));

        // install optional package
        $this->install(new SignalParamModule($this, $this->params));
        $this->install(new AuraFormModule);
        $this->install(new ResourceGraphModule($this));

        // install develop module
        if ($this->context === 'dev') {
            $this->install(new DevModule($this));
        }

        // install API module
        if ($this->context === 'api') {
            // install api output view package
            $this->install(new HalModule($this));
            //$this->install(new JsonModule($this));
        }

        // install application dependency
        $this->install(new App\Dependency);

        // install application aspect
        $this->install(new App\Aspect($this));

    }
}
