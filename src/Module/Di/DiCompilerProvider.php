<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Module\Di;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\FilesystemCache;
use Ray\Di\DiCompiler;
use Ray\Di\ProviderInterface;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class DiCompilerProvider implements ProviderInterface
{
    /**
     * @var string
     */
    private $appName;

    /**
     * @var string
     */
    private $context;

    /**
     * @var string
     */
    private $tmpDir;

    /**
     * @var string
     */
    private $apps;

    /**
     * @var \Ray\Di\DiCompiler
     */
    private static $compiler;

    /**
     * @var \Ray\Di\AbstractModule[]
     */
    private static $module;

    /**
     * @param string $appName
     * @param mixed $context
     * @param string $tmpDir
     *
     * @Inject
     * @Named("appName=app_name,context=app_context,tmpDir=tmp_dir,apps=apps")
     */
    public function __construct($appName, $context, $tmpDir, $apps)
    {
        $this->appName = $appName;
        $this->context = $context;
        $this->tmpDir = $tmpDir;
        $this->apps = $apps;
    }

    /**
     * {@inheritdoc}
     * @return \Ray\Di\DiCompiler
     */
    public function get($extraCacheKey = '')
    {
        $contextKey = is_array($this->context)? implode('_', $this->context) : $this->context;
        $saveKey = $this->appName . $contextKey;
        if (isset(self::$compiler[$saveKey])) {
            return self::$compiler[$saveKey];
        }
        $apps = $this->apps;

        $moduleProvider = function () use ($saveKey, $apps) {
            // avoid infinite loop
            if (isset(self::$module[$saveKey])) {
                return self::$module[$saveKey];
            }
            $appModule = "{$this->appName}\Module\AppModule";
            self::$module[$saveKey] = new $appModule($this->context, $apps);

            return self::$module[$saveKey];
        };

        $cacheKey = $this->appName . $contextKey . $extraCacheKey;
        $cache = function_exists('apc_fetch')? new ApcCache : new FilesystemCache($this->tmpDir);
        self::$compiler[$saveKey] = $compiler = DiCompiler::create($moduleProvider, $cache, $cacheKey, $this->tmpDir);

        return $compiler;
    }
}