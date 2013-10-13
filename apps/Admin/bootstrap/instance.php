<?php
/**
 * Application instance script
 *
 * @return $app  \BEAR\Sunday\Extension\Application\AppInterface
 * @global $context string configuration mode
 */
namespace Skeleton;

use BEAR\Package\Provide\Application\AbstractApp;
use BEAR\Sunday\Extension\Application\AppInterface;
use Doctrine\Common\Cache\ApcCache;
use Ray\Di\CacheInjector;
use Ray\Di\Injector;

require_once __DIR__ . '/autoload.php';

// context
$context = isset($context) ? $context : 'prod';

$injector = function () use ($context) {
    return Injector::create([new Module\AppModule($context)]);
};

$initialization = function (AbstractApp $app) use ($context) {
    $diLog = (string)$app->injector . PHP_EOL . (string)$app->injector->getLogger();
    file_put_contents(dirname(__DIR__) . '/var/log/boot.log', $diLog);
};

$app = (new CacheInjector($injector, $initialization, __NAMESPACE__ . $context, new ApcCache))
    ->getInstance('\BEAR\Sunday\Extension\Application\AppInterface');

/* @var $app \BEAR\Sunday\Extension\Application\AppInterface */
return $app;
