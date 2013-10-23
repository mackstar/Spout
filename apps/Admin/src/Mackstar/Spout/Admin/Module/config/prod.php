<?php

namespace Mackstar\Spout\Admin;

$appDir = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
// @Named($key) => instance
$config = [
    // database
    'master_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'spout',
        'user' => 'root',
        'password' => '',
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'spout',
        'user' => 'root',
        'password' => '',
        'charset' => 'UTF8'
    ],
    // constants
    'app_name' => __NAMESPACE__,
    'app_dir' => $appDir,
    'tmp_dir' => $appDir . '/var/tmp',
    'log_dir' => $appDir . '/var/log',
    'vendor_dir' => $appDir . '/var/lib',
];

return $config;
