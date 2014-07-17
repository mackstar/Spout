<?php

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
$loader->addPsr4('Mackstar\Spout\\', [dirname(__DIR__) . "src/"]);
$loader->addPsr4('Mackstar\Spout\\Test\\', [__DIR__]);

use Doctrine\DBAL\DriverManager;
use Mackstar\Spout\App\Module\AppModule;
use Mackstar\Spout\Bootstrap\Bootstrap;

error_reporting(E_ALL);

// set application root as current directory
chdir(dirname(__DIR__));


ini_set('error_log', sys_get_temp_dir() . 'app-test.log');

// set the application path into the globals so we can access
// it in the tests.
$GLOBALS['APP_DIR'] = dirname(__DIR__);

$config = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/test_db.sqlite3', // sets DB location to root path
    'charset' => 'UTF8'
];

$apps = [
    'site' => 'Spout Test',
    'apps' => [
        'spouttest' => ['namespace' => 'Mackstar\Spout\\Test\\TestApp']
    ],
    'default' => 'spouttest'
];

Bootstrap::registerLoader($loader, $apps, $GLOBALS['APP_DIR']);

$app = Bootstrap::getApp($apps, ['test'], __DIR__ . '/tmp');

$GLOBALS['RESOURCE'] = $app->resource;

$GLOBALS['DB'] = DriverManager::getConnection($config);

