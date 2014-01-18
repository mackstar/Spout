<?php

namespace Mackstar\Spout\Admin\Resource\App\Entities;

use BEAR\Resource\ResourceObject;
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

    protected $table = 'entities';

    /**
     * @Link(rel="type", href="app://self/entities/types?slug={slug}")
     */
    public function onGet()
    {

        $sql  = "SELECT {$this->table}.*, type.name, type.title_label FROM {$this->table} ";
        $sql .= "INNER JOIN entity_types AS type ";
        $sql .= "ON type.slug = {$this->table}.type";
        $this['entity'] = $this->db->fetchAll($sql);

        return $this;
    }
}