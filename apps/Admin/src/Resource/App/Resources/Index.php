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
 * PropertyTypes
 *
 * @Db
 */
class Index extends ResourceObject{

    use DbSetterTrait;
    use ResourceInject;

    protected $table = 'resources';

    /**
     * @Link(rel="type", href="app://self/entities/types?slug={slug}")
     * @DbPager(2)
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

    public function onPost($type, $title, $slug, $fields)
    {
        $resource = $this->resource->get->uri('app://self/resources/types')
            ->eager
            ->withQuery(['slug' => $type['slug']])
            ->request();

        $this->db->beginTransaction();

        try{
            $this->db->insert('resources', ['title' => $title, 'type' => $type['slug'], 'slug' => $slug]);
            $resourceId = $this->db->lastInsertId();

            foreach($resource->body['type']['fields'] as $field){
                $table = 'field_values_' . $field['field_type'];

                if (!isset($fields[$field['slug']])) {
                    continue;
                }

                // Single field insert
                if ($field['multiple'] == '0') {
                    $this->db->insert($table, [
                        'value' => $fields[$field['slug']],
                        'resource_field_id' => $field['id'],
                        'resource_id' => $resourceId
                    ]); 

                // Multiple field insert
                } else {
                    foreach($fields[$field['slug']] as $value) {
                        $this->db->insert($table, [
                            'value' => $value,
                            'resource_field_id' => $field['id'],
                            'resource_id' => $resourceId
                        ]);
                    }
                }
            }
            $this->db->commit();

        } catch(\Exception $e) {
            $this->db->rollback();
            echo $e->getMessage();
            exit;
        }
        

        return $this;
    }
}