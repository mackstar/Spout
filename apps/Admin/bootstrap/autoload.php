<?php
/**
 * load script
 *
 *  set composer auto loader
 *  set silent auto loader for doctrine annotation
 *  set ignore annotation
 *
 * @global $PackageDir
 */
namespace Mackstar\Spout\Admin;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

umask(0);

$packageDir = dirname(dirname(dirname(__DIR__)));
$loader = require $packageDir . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
$loader->set('Mackstar\Spout\Admin', dirname(__DIR__) . '/src');

AnnotationRegistry::registerLoader([$loader, 'loadClass']);
AnnotationReader::addGlobalIgnoredName('noinspection'); // for phpStorm
AnnotationReader::addGlobalIgnoredName('returns'); // for Mr.Smarty. :(
