<?php

/**
 * Welcome to the Mackstar.Spout Project
 *
 * This is where you can override the default configuration.
 * for the *TEST* context. 
 */

return [
    'master_db' => [
        'driver' => 'pdo_sqlite',
        'path' => dirname(dirname(__DIR__)) . '/test_db.sqlite3',
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_sqlite',
        'path' => dirname(dirname(__DIR__)) . '/test_db.sqlite3',
        'charset' => 'UTF8'
    ]
];