<?php

namespace Mackstar\Spout\App\Module;

use BEAR\Package\Module\Form\AuraForm\AuraFormModule;
use BEAR\Package\Module\Package\PackageModule;
use BEAR\Package\Module\Resource\ResourceGraphModule;
use BEAR\Package\Module\Resource\SignalParamModule;
use BEAR\Package\Provide as ProvideModule;
use BEAR\Package\Provide\ResourceView;
use BEAR\Package\Provide\ResourceView\HalModule;
use BEAR\Package\Provide\TemplateEngine\Twig\TwigModule;
use BEAR\Sunday\Module as SundayModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Mackstar\Spout\App\Module\Mode\DevModule;
use Mackstar\Spout\App\Module\Mode\ApiModule;
use Mackstar\Spout\App\Module\App\OuterApiAspect;
use Ray\Di\Scope;

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
    private $constants;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $context;

    private $appDir;

    /**
     * @param string $context
     *
     * @throws \LogicException
     */
    public function __construct($context = 'prod')
    {
        $appDir = dirname(dirname(__DIR__));
        $this->context = $context;
        $this->appDir = $appDir;
        $this->constants = (require "{$appDir}/var/conf/{$context}.php") + (require "{$appDir}/var/conf/prod.php");
        $this->params = (require "{$appDir}/var/lib/params/{$context}.php") + (require "{$appDir}/var/lib/params/prod.php");
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // install core package

        $this->install(new PackageModule('Mackstar\Spout\App\App', $this->context, $this->constants));

        // install view package
        $this->install(new TwigModule($this));

        // install optional package
        $this->install(new SignalParamModule($this, $this->params));
        $this->install(new AuraFormModule);

        // install application dependency
        $this->install(new App\Dependency);

        // install application aspect
        $this->install(new App\Aspect($this));

        // install API module
        if ($this->context === 'api') {
            // install api output view package
            $this->install(new HalModule($this));
            $this->install(new ApiModule($this));
            $this->install(new OuterApiAspect());
        }
    }
}
