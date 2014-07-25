<?php

$confDir = __DIR__;
$map = [
    'path' => 'name',
    'dbname' => 'name',
    'password' => 'pass',
    'driver' => 'adapter' 
];
$defaults = require $confDir . '/defaults.php';

$contexts = array_filter(scandir($confDir . '/contexts'), function ($context) {
    if (strpos($context, '.php')) {
        return true;
    }
});

foreach($contexts as $key => &$file) {
    if (substr($file, 0, 1) == '.') {
        unset($contexts[$key]);
        continue;
    }

    $context         = substr($file, 0, -4);
    $contextOverride = (require $confDir . '/contexts/' . $file);

    $contextConf     = array_replace_recursive($defaults, $contextOverride);
    foreach ($contextConf['master_db'] as $key => $value) {
        if (isset($map[$key])) {
            $dbConf[$context][$map[$key]] = $value;
        } else {
            $dbConf[$context][$key] = $value;
        }
    }
    $dbConf[$context]['adapter'] = str_replace('pdo_', '', $dbConf[$context]['adapter']);
    $dbConf[$context]['name'] = str_replace('.sqlite3', '', $dbConf[$context]['name']);
}

$migrationConf = [

    'paths' => [
        'migrations' => dirname(dirname(__DIR__)) . '/data/migrations'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
    ]
];

$migrationConf['environments'] += $dbConf;

return $migrationConf;