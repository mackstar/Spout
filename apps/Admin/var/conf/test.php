<?php

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
