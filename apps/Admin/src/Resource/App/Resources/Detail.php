<?php

namespace Mackstar\Spout\Admin\Resource\App\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Sunday\Inject\ResourceInject;

/**
 * FieldTypes
 *
 * @Db
 */
class Detail extends ResourceObject{

    use DbSetterTrait;
    use ResourceInject;

    protected $table = 'resources';

    public function onGet($id=null)
    {
        $sql = "SELECT {$this->table}.* FROM {$this->table} WHERE {$this->table}.`id` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $resource = $stmt->fetch();

        $type = $this->resource->get->uri('app://self/resources/types')
            ->eager
            ->withQuery(['slug' => $resource['type']])
            ->request();

        $fieldTypes = [];
        $map = [];
        $resource['fields'] = [];
        foreach($type->body['type']['fields'] as $resourceField) {
        	$map[$resourceField['id']] = $resourceField['slug'];
        	$fieldType = $resourceField['field_type'];
        	$slug = $resourceField['slug'];
        	$resource['fields'][$slug] = [
        		'label' => $resourceField['label'],
        		'value' => ''
        	];
        	if ($resourceField['multiple'] == '1') {
        		$resource['fields'][$slug]['values'] = [];
                unset($resource['fields'][$slug]['value']); 
        	}
        	$resource['fields']['slug'] = '';
        	if (!in_array($fieldType, $fieldTypes)) {
        		$fieldTypes[] = $fieldType;
        	}
        }
        $values = [];
        foreach ($fieldTypes as $fieldType) {
        	$table = 'field_values_' . $fieldType;
        	$sql = "SELECT $table.* FROM $table WHERE $table.`resource_id` = :id";
        	$stmt = $this->db->prepare($sql);
        	$stmt->bindValue('id', $id);
        	$stmt->execute();
        	$fieldTypeRows[] = $stmt->fetchAll();
        }

        foreach($fieldTypeRows as $rows) {
        	foreach ($rows as $row) {
        		$slug = $map[$row['resource_field_id']];

        		if (isset($resource['fields'][$slug]['values'])) {
        			$resource['fields'][$slug]['values'][] = $row['value'];
        		} else {
        			$resource['fields'][$slug]['value'] = $row['value'];
        		}
        	}
        }
        $this['resource'] = $resource;
        return $this;
    }
}