<?php

namespace Mackstar\Spout\Admin\Resource\App\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Resource\Annotation\Link;
use BEAR\Sunday\Annotation\DbPager;
use PDO;

/**
 * Resources Index
 *
 * @Db
 */
class Index extends ResourceObject
{
    use DbSetterTrait;
    use ResourceInject;

    protected $table = 'resources';

    /**
     * @Link(rel="type", href="app://self/entities/types?slug={slug}")
     * @DbPager(5)
     */
    public function onGet()
    {
        $sql  = "SELECT {$this->table}.*, type.name as type_name, type.title_label FROM {$this->table} ";
        $sql .= "INNER JOIN resource_types AS type ";
        $sql .= "ON type.slug = {$this->table}.type";

        $stmt = $this->db->query($sql);
        $this['resources'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$this['resources'] = $this->db->fetchAll($sql);

        return $this;
    }

    public function onDelete($id, $type)
    {
        $resource = $this->getType($type);
        $this->db->beginTransaction();

        try {
            $this->db->delete($this->table, ['id' => $id]);
            $this->deleteFields($id, $resource);
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollback();
            echo $e->getMessage();
        }

        return $this;
    }

    public function onPost($type, $title, $slug, $fields)
    {
        $resource = $this->getType($type['slug']);
        $this->db->beginTransaction();

        try {
            $this->db->insert('resources', ['title' => $title, 'type' => $type['slug'], 'slug' => $slug]);
            $id = $this->db->lastInsertId();
            $this->insertFields($resource, $fields, $id);
            $this->db->commit();

        } catch (\Exception $e) {
            $this->db->rollback();
            echo $e->getMessage();
        }

        return $this;
    }


    /**
     * Updates resource by
     *  - Updating main resource - this will be title and slug only
     *  - Iterating through fields deleting and reinserting the data in correct field type
     *
     * @todo add versioning.
     *
     * @param $id
     * @param $type
     * @param $title
     * @param $slug
     * @param $fields
     * @return $this
     */
    public function onPut($id, $type, $title, $slug, $fields)
    {
        $resource = $this->getType($type['slug']);
        $this->db->beginTransaction();

        try {
            $this->db->update('resources', ['title' => $title, 'slug' => $slug], ['id' => $id]);
            $this->deleteFields($id, $resource);
            $this->insertFields($resource, $fields, $id);
            $this->db->commit();

        } catch (\Exception $e) {
            $this->db->rollback();
            echo $e->getMessage();
        }

        return $this;
    }

    private function insertFields($resource, $fields, $id)
    {
        foreach ($resource->body['type']['fields'] as $field) {
            $table = 'field_values_' . $field['field_type'];

            if (!isset($fields[$field['slug']])) {
                continue;
            }

            // Single field insert
            if ($field['multiple'] == '0') {
                $this->db->insert($table, [
                    'value' => $fields[$field['slug']],
                    'resource_field_id' => $field['id'],
                    'resource_id' => $id
                ]);

            } else {

                // Multiple field insert
                foreach ($fields[$field['slug']] as $value) {
                    $this->db->insert($table, [
                        'value' => $value,
                        'resource_field_id' => $field['id'],
                        'resource_id' => $id
                    ]);
                }
            }
        }
    }

    private function deleteFields($id, $resource)
    {
        $fieldTypes = [];
        foreach ($resource->body['type']['fields'] as $field) {
            if (!in_array($field['field_type'], $fieldTypes)) {
                $fieldTypes[] = $field['field_type'];
                $this->db->delete('field_values_' . $field['field_type'], ['resource_id' => $id]);
            }
        }
    }

    private function getType($slug)
    {
        return $this->resource->get->uri('app://self/resources/types')
            ->eager
            ->withQuery(['slug' => $slug])
            ->request();
    }
}
