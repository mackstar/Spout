<?php

namespace Mackstar\Spout\Admin\Resource\App\Users;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use Mackstar\Spout\Interfaces\SecurityInterface;
use Ray\Di\Di\Inject;

/**
 * Users
 *
 * @Db
 */
class Roles extends ResourceObject{

    use DbSetterTrait;

    protected $table = 'roles';

    public function onGet()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY 'weight'";
        $this['roles'] = $this->db->fetchAll($sql);
        

        return $this;
    }
}