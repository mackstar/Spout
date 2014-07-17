<?php
/**
 * This file is part of the Mackstar.SpoutSite package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Test\TestApp\Module;

use Mackstar\Spout\App\Module\AppModule as SpoutModule;

/**
 * Application module available for you to override standard
 * Mackstar.Spout AppModule.
 */
class AppModule extends SpoutModule
{
    /**
     * @param array $contexts
     */
    public function __construct($contexts, $apps)
    {
        parent::__construct($contexts, $apps);
    }
}