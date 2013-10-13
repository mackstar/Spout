#! /usr/bin/env php
<?php
/**
 * Application compiler
 *
 * This script
 *
 * + creates var/lib/preloader/preload.php which contains all class in this application.
 * + creates application object in cache.
 * + creates all resource object in cache.
 * + creates all aspect weaved resource files.
 *
 * You can use this script in console if you use file cache.
 * But if you want to use APC cache, `include` this file once in web per deploy.
 *
 * @see https://github.com/mtdowling/ClassPreloader
 */

ini_set('display_errors', 1);
ini_set('xhprof.output_dir', sys_get_temp_dir());

require dirname(__DIR__) . '/bootstrap/autoload.php';

$packageDir = dirname(dirname(dirname(__DIR__)));

$preLoader = $packageDir . '/vendor/bin/classpreloader.php';
$config = dirname(__DIR__) . '/var/lib/preloader/config.php';
$output = dirname(__DIR__) . '/var/tmp/preloader/preload.php';

$cmd = "php {$preLoader} compile --config={$config} --output={$output}";

echo $cmd . PHP_EOL;
passthru($cmd);
