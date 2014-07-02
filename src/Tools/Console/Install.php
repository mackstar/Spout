<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Tools\Console;

use Composer\Script\Event;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class Install
{
    public static function postUpdate(Event $event)
    {
        $currentDir = getcwd();
        $wwwDest    = $currentDir . '/var/www/';
        $wwwSrc     = self::getBaseDir() . '/dist/spout-admin';

        if (!is_dir($wwwDest)) {
            echo "No `www` directory found, please make sure it exists at `var/www`";
            exit();
        }

        echo `cp -R $wwwSrc $wwwDest`;

        $wwwSrc   = self::getBaseDir() . '/dist/template/layout/*';
        $wwwDest    = $currentDir . '/lib/twig/template/';

        echo `cp -R $wwwSrc $wwwDest`;
        echo "";
        echo "Welcome to Mackstar.Spout";
    }

    public static function getBaseDir() {
        return dirname(dirname(dirname(__DIR__)));
    }
}
