<?php

/**
 * Welcome to the Mackstar.Spout Project
 *
 * This is where the main configuration is added.
 * You can override this per environment in 
 * /conf/env/{env}.php
 *  
 */
$appDir = dirname(__DIR__);

return [
    'tmp_dir' => dirname(__DIR__) . '/var/tmp',
    'upload_dir' => dirname(__DIR__) . '/var/www/uploads',
    'resource_dir' => dirname(__DIR__),
    'lib_dir' => $appDir . '/lib',
    'log_dir' => $appDir . '/var/log',
    'template_dir' => $appDir . '/lib/twig/template'

];