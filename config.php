<?php

$configPath = __DIR__ . '/apps/Admin/src/Mackstar/Spout/Admin/Module/config/';
$prod = require($configPath . '/prod.php');
$dev = require($configPath . '/prod.php');
$test = require($configPath . '/test.php');

return [
	
	'paths' => [
		'migrations' => 'data/migrations'
	],
	'environments' => [
		'default_migration_table' => 'phinxlog',
		'default_database' => 'development',
		'production' => [
			'adapter' => str_replace('pdo_', '', $prod['master_db']['driver']),
			'host' => $prod['master_db']['host'],
			'name' => $prod['master_db']['dbname'],
			'user' => $prod['master_db']['user'],
			'pass' => $prod['master_db']['password'],
			'port' => '3306'
		],
		'development' => [
			'adapter' => str_replace('pdo_', '', $dev['master_db']['driver']),
			'host' => $dev['master_db']['host'],
			'name' => $dev['master_db']['dbname'],
			'user' => $dev['master_db']['user'],
			'pass' => $dev['master_db']['password'],
			'port' => '3306'
		],
		'testing' => [
			'adapter' => 'sqlite',
			'host' => 'localhost',
			'name' => 'test_db',
			'user' => 'root',
			'pass' => '',
			'port' => '3306'
		]
	]
];
