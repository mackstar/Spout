<?php

namespace Mackstar\Spout\Admin\Resource\App\Users;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Sunday\Annotation\Db;
use Mackstar\Spout\Interfaces\SecurityInterface;
use Ray\Di\Di\Inject;

/**
 * Authenticate Users
 *
 * @Db
 */
class Authenticate extends ResourceObject{

    use DbSetterTrait;

    protected $security;
    protected $table = 'users';

    /**
     * @Inject
     */
    public function setSecurity(SecurityInterface $security) {
        $this->security = $security;
    }

    public function onPost(
        $email,
        $password
    ) {

        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && $this->security->match($password, $user['password'])) {
            unset($user['password']);
            $this['user'] = $user;
        } else {
            $this->code = 400;
            $this['message'] = 'Your aucthentication details didn\'t match.';
        }

        return $this;
    }

}