<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Params;

use BEAR\Resource\ParamProviderInterface;
use BEAR\Resource\ParamInterface;

class CurrentTime implements ParamProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ParamInterface $param)
    {
        $time = date("Y-m-d H:i:s", time());
        return $param->inject($time);
    }
}
