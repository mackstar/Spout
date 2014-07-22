<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Bootstrap;

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;
use Mackstar\Spout\Module\Di\DiCompilerProvider;

class Bootstrap
{
    /**
     * @param ClassLoader $loader
     * @param string      $apps
     * @param string      $appDir
     */
    public static function registerLoader(ClassLoader $loader, &$apps, $appDir)
    {
        foreach ($apps['apps'] as &$app) {
            $namespace = $app['namespace'] . '\\';
            $prefixes = $loader->getPrefixesPsr4();
            if (isset($prefixes[$namespace])) {
                $app['path'] = $prefixes[$namespace][0];
                continue;
            }
            $app['path'] = $loader->getPrefixesPsr4()[$namespace];
        }
        AnnotationRegistry::registerLoader([$loader, 'loadClass']);
        AnnotationReader::addGlobalIgnoredName('noinspection');
        AnnotationReader::addGlobalIgnoredName('returns');
    }

    /**
     * @param $apps
     * @param $context
     * @param $tmpDir
     *
     * @return \BEAR\Sunday\Extension\Application\AppInterface
     */
    public static function getApp($apps, $context, $tmpDir)
    {
        $appName = $apps['apps'][$apps['default']]['namespace'];
        $extraCacheKey = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_METHOD'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
        $diCompiler = (
            new DiCompilerProvider(
                $appName,
                $context,
                $tmpDir, 
                $apps
            )
        )->get($extraCacheKey);
        $app = $diCompiler->getInstance('BEAR\Sunday\Extension\Application\AppInterface');

        return $app;
    }

    public static function setDefaultRoutes($router)
    {
        return $routes;
    }

    public static function clearApp(array $dirs)
    {
        // APC Cache
        if (function_exists('apc_clear_cache')) {
            if (version_compare(phpversion('apc'), '4.0.0') < 0) {
                apc_clear_cache('user');
            }
            apc_clear_cache();
        }

        $unlink = function ($path) use (&$unlink) {
            foreach (glob(rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*') as $file) {
                is_dir($file) ? $unlink($file) : unlink($file);
                @rmdir($file);
            }
        };
        foreach ($dirs as $dir) {
            $unlink($dir);
        }
        $unlink(dirname(__DIR__) . '/var/tmp');
    }
}
