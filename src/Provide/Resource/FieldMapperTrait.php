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

/**
 * Class FieldMapperTrait
 *
 * @package Mackstar.Spout
 */
trait FieldMapperTrait {

    /**
     * @var array
     */
    protected $writeMapping = [
        'media' => ['uuid' => 'uuid'],
        'resource' => ['type' => 'type', 'slug' => 'slug']
    ];

    protected $readMapping = [
        'media' => [ 'uri' => 'app://spout/media/index', 'query' => ['uuid' => '{:uuid}']],
        'resource' => [ 'uri' => 'app://spout/resources/embedded', 'query' => ['slug' => '{:slug}', 'type' => '{:type}']]
    ];

    /**
     * A method for sorting what field names in the 'field types' table
     * need be mapped to what input parameters from JSON feed.
     *
     * @param $field
     * @param $value
     * @return array
     */
    private function getWriteMapping($field, $value)
    {
        if (!isset($this->writeMapping[$field])) {
            return ['value' => $value];
        }
        $mapping = $this->writeMapping[$field];
        $mappedValues = [];
        foreach ($mapping as $key => $fieldMapping) {
            $mappedValues[$key] = $value[$fieldMapping];
        }
        return $mappedValues;
    }

    private function getReadMapping($type, $field)
    {
        if (!isset($this->readMapping[$type])) {
            return;
        }
        $mapping = $this->readMapping[$type];
        foreach ($mapping['query'] as &$param) {
            $this->getReplacement($param, $field);
        }
        return $mapping;
    }

    private function getReplacement(&$param, $field)
    {
        preg_match_all("/\{:([a-zA-Z0-9]+)\}/", $param, $matches);
        if (!isset($matches[1])) {
            return;
        }
        foreach ($matches[1] as $match) {
            $param = preg_replace($param, "/\{:$match\}/", $field[$match]);
        }
    }
} 