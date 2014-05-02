<?php

$config = [
    'driver' => 'pdo_sqlite',
    'path' => '../../test_db.sqlite3',
    'charset' => 'UTF8'
];

return [
    'master_db' => $config,
    'slave_db' => $config
];
