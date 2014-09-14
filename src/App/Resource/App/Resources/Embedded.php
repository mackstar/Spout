<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Resources;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Sunday\Inject\ResourceInject;
use Mackstar\Spout\Provide\Resource\FieldMapperTrait;

/**
 * FieldTypes
 *
 * @Db
 */
class Embedded extends ResourceObject
{

    use DbSetterTrait;
    use ResourceInject;
    use FieldMapperTrait;

    protected $table = 'resources';

    public function onGet($type = null, $slug = null)
    {
        $sql = "SELECT {$this->table}.* FROM {$this->table} WHERE `slug` = :slug AND `type` = :type";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('type', $type);
        $stmt->bindValue('slug', $slug);
        $stmt->execute();
        $resource = $stmt->fetch();
        if (!$resource) {
            $this['resource'] = [];
            return $this;
        }

        try {
            $resource['_meta'] = $this->resource->get->uri('app://spout/resources/types')
                ->eager
                ->withQuery(['slug' => $resource['type']])
                ->request()
                ->body['type'];
        } catch (\Exception $e) {
            var_dump("error:");
            echo($e->getTraceAsString());
        }

        $fieldTypes = [];
        // Map of fieldids against field config
        $map = [];
        foreach ($resource['_meta']['fields'] as $field) {
            $map[$field['id']] = $field;
            $fieldType = $field['field_type'];
            $slug = $field['slug'];
            $resource[$slug] = ($field['multiple'] == '1')? [] : '';
            if (!in_array($fieldType, $fieldTypes)) {
                $fieldTypes[] = $fieldType;
            }
        }
        foreach ($fieldTypes as $fieldType) {
            $table = 'field_values_' . $fieldType;
            $sql = "SELECT $table.* FROM $table WHERE $table.`resource_id` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('id', $resource['id']);
            $stmt->execute();
            $fieldValuesByType[] = $stmt->fetchAll();
        }

        foreach ($fieldValuesByType as $fieldValues) {
            foreach ($fieldValues as $fieldValue) {
                $slug = $map[$fieldValue['resource_field_id']]['slug'];
                $fieldType = $map[$fieldValue['resource_field_id']]['field_type'];
                $value = isset($fieldValue['value'])? $fieldValue['value'] : null;

                if (is_null($value) && $fieldType != 'resource') {
                    $mapping = $this->getReadMapping($fieldType, $fieldValue);

                    $response = $this->resource->get->uri($mapping['uri'])
                        ->eager
                        ->withQuery($mapping['query'])
                        ->request();
                    if (isset($response['_model'])) {
                        $value = $response[$response['_model']];
                    }
                }

                if ($fieldType == 'resource') {
                    $mapping = $this->getReadMapping($fieldType, $fieldValue);
                    $resource['_resourcelinks'][$slug] = $mapping['uri'] . '?';
                    foreach ($mapping['query'] as $key => $value) {
                        $resource['_resourcelinks'][$slug] .= $key . '=' . $value . '&';
                    }
                    if (substr($resource['_resourcelinks'][$slug], -1) == '&') {
                        $resource['_resourcelinks'][$slug] = substr($resource['_resourcelinks'][$slug], 0, -1);
                    }
                    unset($resource[$slug]);
                    continue;
                }


                if (is_array($resource[$slug])) {
                    $resource[$slug][] = $value ;
                } else {
                    $resource[$slug] = $value;
                }
            }
        }
        foreach ($resource as $key => $value) {
            $this[$key] = $value;
        }
        return $this;
    }
}
