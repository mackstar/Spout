<?php

namespace Mackstar\Spout\Admin\Resource\App\Menus;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * Add
 *
 * @Db
 */
class Links extends ResourceObject{

    use DbSetterTrait;

    protected $table = 'links';

    public function onPost($menu)
    {

        $sql  = "SELECT {$this->table}.* FROM {$this->table} ";
        $this['resources'] = $this->db->fetchAll($sql);

        return $this;
    }

    public function onGet($menu)
    {
        $sql = "SELECT * FROM {$this->table} WHERE `menu` = '{$slug}'";
        $this['links'] = $this->db->fetchAll($sql);
        return $this;
    }


}