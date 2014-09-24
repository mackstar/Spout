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
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Resource\Annotation\Link;
use BEAR\Sunday\Annotation\DbPager;
use Mackstar\Spout\Provide\Resource\FieldMapperTrait;
use Mackstar\Spout\Provide\Resource\UserIdSetterTrait;
use Mackstar\Spout\App\Annotation\UserIdInject;
use PDO;

/**
 * Resources Index
 *
 * @Db
 * @UserIdInject
 */
class Index extends ResourceObject
{
    use DbSetterTrait;
    use ResourceInject;
    use FieldMapperTrait;
    use UserIdSetterTrait;

    protected $table = 'resources';

    /**
     * @Link(rel="type", href="app://spout/entities/types?slug={slug}")
     * @DbPager(20)
     */
    public function onGet($type = null)
    {
        $sql  = "SELECT {$this->table}.*, type.name as type_name, type.title_label FROM {$this->table} ";
        $sql .= "INNER JOIN resource_types AS type ";
        $sql .= "ON type.slug = {$this->table}.type";

        $stmt = $this->db->query($sql);
        $this['resources'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this;
    }

    /**
     * Deletes resource
     *
     * @param $id
     * @param $type
     * @return $this
     */
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

    /**
     * Creates resource
     *
     * @param $type
     * @param $title
     * @param $slug
     * @param $fields
     * @return $this
     */
    public function onPost($now, $type, $title, $slug, $fields)
    {
        $resource = $this->getType($type['slug']);
        $this->db->beginTransaction();

        try {
            $this->db->insert('resources', [
                'title' => $title,
                'type' => $type['slug'],
                'slug' => $slug,
                'created' => $now,
                'updated' => $now,
                'user_id' => $this->user_id
            ]);
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

    /**
     * This discerns whether a field is multiple or singular and
     * inserts each of the field values to the database accordingly.
     *
     * @param $resource
     * @param $fields
     * @param $id
     */
    private function insertFields($resource, $fields, $id)
    {
        foreach ($resource->body['type']['fields'] as $field) {
            $fieldType = $field['field_type'];
            $table = 'field_values_' . $fieldType;

            if (!isset($fields[$field['slug']])) {
                continue;
            }

            if ($fieldType == 'date') {
                $fields[$field['slug']] = date('Y-m-d', strtotime($fields[$field['slug']]));
            }

            if ($fieldType == 'time') {
                $fields[$field['slug']] = date('H:i:s', strtotime($fields[$field['slug']]));
            }


            // Single field insert
            if ($field['multiple'] == '0') {
                $mappedValues = $this->getWriteMapping($fieldType, $fields[$field['slug']]);
                $this->db->insert($table, array_merge($mappedValues, [
                    'resource_field_id' => $field['id'],
                    'resource_id' => $id
                ]));

            }

            // Multiple field insert
            if ($field['multiple'] == '1') {
                foreach ($fields[$field['slug']] as $value) {
                    $mappedValues = $this->getWriteMapping($fieldType, $value);
                    $this->db->insert($table, array_merge($mappedValues, [
                        'resource_field_id' => $field['id'],
                        'resource_id' => $id
                    ]));
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
        return $this->resource->get->uri('app://spout/resources/types')
            ->eager
            ->withQuery(['slug' => $slug])
            ->request();
    }
}