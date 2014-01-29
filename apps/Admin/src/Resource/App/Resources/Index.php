<?php

namespace Mackstar\Spout\Admin\Resource\App\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Resource\Annotation\Link;

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
     */
    public function onGet()
    {

        $sql  = "SELECT {$this->table}.*, type.name as type_name, type.title_label FROM {$this->table} ";
        $sql .= "INNER JOIN resource_types AS type ";
        $sql .= "ON type.slug = {$this->table}.type";
        $this['resources'] = $this->db->fetchAll($sql);

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
            $this->db->insert('resources', ['title' => 'title', 'type' => $type['name'], 'slug' => $slug]);
            var_dump($this->db->lastInsertId());
            $this->db->commit();

        } catch(\Exception $e) {
            var_dump("rolled back");
            $this->db->rollback();
        }
        

        return $this;
    }
}