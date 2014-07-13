<?php
/**
 * This file is part of the Mackstar.Spout package.
 * 
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\Resource;

use BEAR\Resource\ResourceObject as BEARResourceObject;

class ResourceObject extends BEARResourceObject
{
    private $template;

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getTemplate()
    {
        return $this->template;
    }
}