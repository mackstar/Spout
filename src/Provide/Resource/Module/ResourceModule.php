<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\Resource\Module;

use Ray\Di\AbstractModule;
use BEAR\Resource\Module\NamedArgsModule;

class ResourceModule extends AbstractModule
{
    /**
     * @var string
     */
    private $appName;

    /**
     * @var string
     */
    private $resourceDir;

    /**
     * @param string $appName
     */
    public function __construct($appName, $resourceDir = '')
    {
        $this->appName = $appName;
        $this->resourceDir = $resourceDir;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new NamedArgsModule);
        $this->install(new ResourceClientModule($this->appName, $this->resourceDir));
        //$this->install(new EmbedResourceModule($this));
    }
}
