<?php

use Doctrine\DBAL\DriverManager;
use Mackstar\Spout\Admin\Module\AppModule;
use Ray\Di\Injector;

error_reporting(E_ALL);

// set application root as current directory
chdir(dirname(__DIR__));

// dev tools
$loader = require dirname(dirname(dirname(__DIR__))) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
$loader->add('Mackstar', __DIR__ . '/src');
ini_set('error_log', sys_get_temp_dir() . 'app-test.log');

// init
require_once dirname(__DIR__). '/bootstrap/autoload.php';

// set the application path into the globals so we can access
// it in the tests.
$GLOBALS['APP_DIR'] = dirname(__DIR__);

// set the resource client
$config = require  'src/Mackstar/Spout/Admin/Module/config/test.php';

$injector = Injector::create([new AppModule('test')]);

$GLOBALS['RESOURCE'] = $injector->getInstance('\BEAR\Resource\ResourceInterface');

$GLOBALS['DB'] = DriverManager::getConnection($config['master_db']);
