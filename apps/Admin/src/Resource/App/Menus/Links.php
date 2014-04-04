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

    public function onPost($user)
    {

        $sql  = "SELECT {$this->table}.* FROM {$this->table} ";
        $this['resources'] = $this->db->fetchAll($sql);

        return $this;
    }

    public function onGet()
    {
        $sql = "SELECT * FROM {$this->table}";
        $this['menus'] = $this->db->fetchAll($sql);
        return $this;
    }


}