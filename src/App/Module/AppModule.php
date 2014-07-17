<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Module;

use BEAR\Package\Module\Form\AuraForm\AuraFormModule;
use BEAR\Package\Module\Resource\ResourceGraphModule;
use BEAR\Package\Module\Resource\SignalParamModule;
use BEAR\Package\Provide as ProvideModule;
use BEAR\Package\Provide\ResourceView;
use BEAR\Package\Provide\ResourceView\HalModule;
use BEAR\Sunday\Module as SundayModule;
use Mackstar\Spout\App\Module\App\OuterApiAspect;
use Mackstar\Spout\App\Module\Mode\DevModule;
use Mackstar\Spout\App\Module\Mode\ApiModule;
use Mackstar\Spout\Module\PackageModule;
use Mackstar\Spout\Provide\Router\Module as RouterModule;
use Mackstar\Spout\Provide\TemplateEngine\Twig\TwigModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
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
    private $constants = [ 'apps' => [
            'spout' => [
                'namespace' => 'Mackstar\\Spout\\App'
            ]
        ]
    ];

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var array
     */
    private $context = [];

    /**
     * @var array
     */
    private $apps = [];

    /**
     * @var string
     */
    private $env;

    private $appDir;

    /**
     * @param array $contexts
     */
    public function __construct($contexts, $apps)
    {
        $this->context = $contexts;
        $appDir = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
        $this->appDir = $appDir;
        $this->constants +=  (require "{$appDir}/conf/defaults.php");
        foreach ($this->context as $context) {
            $this->constants = array_replace_recursive(
                $this->constants, 
                (require "{$appDir}/conf/contexts/{$context}.php")
            );
        }

        $this->constants['site_name'] = $apps['site'];
        $this->constants['default_site'] = $apps['default'];
        $this->constants['apps']['spout']['path'] = dirname(__DIR__);
        $this->constants['apps'] = array_replace_recursive(
            $this->constants['apps'],
            $apps['apps']
        );
        $this->constants['app_name'] = $this->constants['apps'][$apps['default']]['namespace'];

        $this->params = [];
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
        if (in_array('api', $this->context)) {
            // install api output view package
            $this->install(new HalModule($this));
            $this->install(new ApiModule($this));
            $this->install(new OuterApiAspect());
        }

        
        $this->install(new RouterModule($this));
    }
}
