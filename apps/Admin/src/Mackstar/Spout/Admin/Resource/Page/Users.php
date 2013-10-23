<?php

namespace Mackstar\Spout\Admin\Resource\Page;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use PDO;

/**
 * Users
 *
 * @Db
 */
class Users extends ResourceObject
{
    use ResourceInject;
    use DbSetterTrait;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @param int $id
     */
    public function onGet($id = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        if (is_null($id)) {
            //$this->body = $this->db->fetchAll($sql);
        } else {
//            $sql .= " WHERE id = :id";
//            $stmt = $this->db->prepare($sql);
//            $stmt->bindValue('id', $id);
//            $stmt->execute();
//            $this->body = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $this['text'] = 'text';

        return $this;
    }
}