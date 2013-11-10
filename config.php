<?php

return [
	
	'paths' => [
		'migrations' => 'data/migrations'
	],
	'environments' => [
		'default_migration_table' => 'phinxlog',
		'default_database' => 'development',
		'production' => [
			'adapter' => 'mysql',
			'host' => 'localhost',
			'name' => 'production_db',
			'user' => 'root',
			'pass' => '',
			'port' => '3306'
		],
		'development' => [
			'adapter' => 'mysql',
			'host' => 'localhost',
			'name' => 'development_db',
			'user' => 'root',
			'pass' => '',
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