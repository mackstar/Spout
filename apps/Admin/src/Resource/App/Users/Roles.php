<?php

namespace Mackstar\Spout\Admin\Resource\App\Users;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use Ray\Di\Di\Inject;

/**
 * Users
 *
 * @Db
 */
class Roles extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'roles';

    public $headers = [
    ];

    public function onGet($id = null)
    {
        $sql = "SELECT * FROM {$this->table}";

        if (is_null($id)) {
            $this['roles'] = $this->db->fetchAll($sql . ' ORDER BY \'weight\'');
        } else {
            $sql .= " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('id', $id);
            $stmt->execute();
            $this['role'] = $stmt->fetch();
        }

        return $this;
    }
}
