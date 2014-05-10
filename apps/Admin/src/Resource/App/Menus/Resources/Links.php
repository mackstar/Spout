<?php

namespace Mackstar\Spout\Admin\Resource\App\Menus\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * Add
 *
 * @Db
 */
class Links extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'links';

    public function onPost($menu, $resourceType, $resource)
    {

        $sql  = "SELECT {$this->table}.* FROM {$this->table} ";
        $this['resources'] = $this->db->fetchAll($sql);

        return $this;
    }


}
