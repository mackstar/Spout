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
        'media' => ['uuid' => 'uuid']
    ];

    protected $readMapping = [
        'media' => [ 'uri' => 'app://self/media/index', 'params' => "{:uuid}"]
    ];

    /**
     * A method for sorting what field names in the 'field types' table
     * need be mapped to what input parameters from JSON feed.
     *
     * @param $field
     * @param $value
     * @return array
     */
    private function getMapping($field, $value)
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
} 