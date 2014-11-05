<?php

/**
 * Welcome to the Mackstar.Spout Project
 *
 * This is where the parameters to be injected into resources
 * are placed.
 *  [
 *      $context = [
 *          $parameterName => $ParameterProviderClass
 *      ]
 * ];
 */
return [
    'prod' => [
        'now' => '\Mackstar\Spout\App\Params\CurrentTime'
    ],
    'test' => [],
    'dev' => [],
    'api' => [],
    'stub' => [],
];