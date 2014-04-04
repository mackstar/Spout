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
class Index extends ResourceObject
{

    use DbSetterTrait;

    protected $table = 'menus';


    public function onPost(
        $name,
        $slug
    ) {

        $this->db->insert('menus', [
            'name' => $name,
            'slug' => $slug
        ]);
        return $this;
    }

    public function onGet()
    {
        $sql = "SELECT * FROM {$this->table}";
        $this['menus'] = $this->db->fetchAll($sql);
        return $this;
    }


}