<?php

$id = isset($_SERVER['BEAR_DB_ID']) ? $_SERVER['BEAR_DB_ID'] : 'root';
$password = isset($_SERVER['BEAR_DB_PASSWORD']) ? $_SERVER['BEAR_DB_PASSWORD'] : '';

return [
    'master_db' => [
        'driver' => 'pdo_sqlite',
        'path' => '../../test_db.sqlite3',
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_sqlite',
        'path' => '../../test_db.sqlite3',
        'charset' => 'UTF8'
    ]
];
