<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
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
        $composer = $event->getComposer();
        var_dump($composer);
    }
}
