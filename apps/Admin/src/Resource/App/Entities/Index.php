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

        $sql = "SELECT * FROM {$this->table}";
        $this['entity'] = $this->db->fetchAll($sql);

        return $this;
    }
}