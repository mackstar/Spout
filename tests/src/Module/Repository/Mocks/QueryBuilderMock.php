<?php
/**
 * This file is part of the Mackstar.SpoutSite package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mackstar\Spout\Test\Module\Repository\Mocks;

class QueryBuilderMock
{
    public function __call($method, $select) {
        $this->$method = func_get_args()[1];
        return $this;
    }
}