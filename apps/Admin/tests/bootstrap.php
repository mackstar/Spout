<?php

use Ray\Di\Injector;
use Mackstar\Spout\Admin\Module\AppModule;

error_reporting(E_ALL);

// set application root as current directory
chdir(dirname(__DIR__));

// dev tools
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
$loader->add('Mackstar', __DIR__ . '/src');
ini_set('error_log', sys_get_temp_dir() . 'app-test.log');

// init
require_once dirname(__DIR__). '/bootstrap/autoload.php';

// set the application path into the globals so we can access
// it in the tests.
$GLOBALS['APP_DIR'] = dirname(__DIR__);

// set the resource client
$GLOBALS['RESOURCE'] = Injector::create([new AppModule('test')])->getInstance('\BEAR\Resource\ResourceInterface');
