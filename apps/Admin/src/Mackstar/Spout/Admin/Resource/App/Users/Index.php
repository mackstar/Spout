<?php

namespace Mackstar\Spout\Admin\Resource\App\Users;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use Mackstar\Spout\Interfaces\SecurityInterface;
use Mackstar\Spout\Admin\Annotation\Form;
use Ray\Di\Di\Inject;

/**
 * Users
 *
 * @Db
 */
class Index extends ResourceObject{

    use DbSetterTrait;

    protected $table = 'users';
    protected $security;

    /**
     * @Inject
     */
    public function setSecurity(SecurityInterface $security) {
        $this->security = $security;
    }

    public function onGet($email = null)
    {
        $sql = "SELECT * FROM {$this->table}";

        if (is_null($email)) {
            $this['users'] = $this->db->fetchAll($sql);
        } else {
            $sql .= " WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('email', $email);
            $stmt->execute();
            $this['user'] = $stmt->fetch();
        }

        return $this;
    }

    /**
     *  @Form
     */
    public function onPost(
        $email,
        $name,
        $password,
        $role
    ) {


    // $this->db->insert('users', [
    //     'name' => $name,
    //     'email' => $email,
    //     'password' => $this->security->encrypt($password),
    //     'role_id' => $role->id
    // ]);
    return $this;
    }

}