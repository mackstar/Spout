<?php

namespace Mackstar\Spout\Admin\Resource\App\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * FieldTypes
 *
 * @Db
 */
class ResourceFields extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'resource_fields';

    public function onGet($id)
    {

        $sql  = "SELECT {$this->table}.* FROM {$this->table} ";
        $this['resources'] = $this->db->fetchAll($sql);

        return $this;
    }
}
