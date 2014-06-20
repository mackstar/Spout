<?php

namespace Mackstar\Spout\App;

$id = isset($_SERVER['BEAR_DB_ID']) ? $_SERVER['BEAR_DB_ID'] : 'root';
$password = isset($_SERVER['BEAR_DB_PASSWORD']) ? $_SERVER['BEAR_DB_PASSWORD'] : '';

$slaveId = isset($_SERVER['BEAR_DB_ID_SLAVE']) ? $_SERVER['BEAR_DB_ID_SLAVE'] : 'root';
$slavePassword = isset($_SERVER['BEAR_DB_PASSWORD_SLAVE']) ? $_SERVER['BEAR_DB_PASSWORD_SLAVE'] : '';

// @Named($key) => instance
$config = [
    // database
    'master_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'spout',
        'user' => $id,
        'password' => $password,
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'spout',
        'user' => $slaveId,
        'password' => $slavePassword,
        'charset' => 'UTF8'
    ],

];


return $config;
