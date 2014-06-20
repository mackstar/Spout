<?php

namespace Mackstar\Spout\App;

/**
 * Signal Parameter
 *
 * format:
 *
 * $varName => $paramProvider
 */
$params = [
    'currentTime' => __NAMESPACE__ . '\Params\CurrentTime',
    'now' => __NAMESPACE__ . '\Params\CurrentTime'
];

return $params;
