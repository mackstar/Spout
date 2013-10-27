<?php
/**
 * CLI / Built-in web server script for development
 *
 * This script is the entry point for CLI an application whilst in development. When in production look
 * at index.php. This script is a base guideline and this procedural boot strap is gives you some defaults
 * as a guide. You are free to change and configure this script at will.
 *
 * CLI:
 * $ php web.php get /
 * $ php web.php get / prod
 * $ php web.php get / api
 *
 * Built-in web server:
 * $ php -S localhost:8080 web.php
 *
 * @global  $context string
 */

ob_start();

$dir = dirname(dirname(__DIR__));

//
// Here we get an application instance by setting a $context variable such as (Prod, Dev, Api, Stub, Test)
// the dev instance provides debugging tools and defaults to help you the development of your application.
//
$context = 'dev';
$app = require $dir . '/bootstrap/develop/instance.php';
/* @var $app \BEAR\Package\Provide\Application\AbstractApp */

//
// The cache is cleared on each request via the following script. We understand that you may want to debug
// your application with caching turned on. When doing so just comment out the following.
//
//require $dir . '/bin/clear.php';

//
// When using the built in file-server when directly accessing files the app instance will not be created and
// and the script will be exited.
if (!$app) {
    return false;
}

//
// Calling the match of a BEAR.Sunday compatible router will give us the $method, $pagePath, $query to be used
// in the page request.
//
list($method, $pagePath, $query) = $app->router->match();

//
// An attempt to request the page resource is made along with setting the response with the resource itself.
// Upon failure the exception handler will be triggered.
//
try {
    $app->page = $app->resource->$method->uri('page://self/' . $pagePath)->withQuery($query)->eager->request();
    $app->response->setResource($app->page)->render()->send();
    exit(0);
} catch (Exception $e) {
    $app->exceptionHandler->handle($e);
    exit(1);
}
