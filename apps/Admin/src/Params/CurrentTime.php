<?php

namespace Mackstar\Spout\Admin\Params;

use BEAR\Resource\ParamProviderInterface;
use BEAR\Resource\ParamInterface;
use BEAR\Resource\Param;

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