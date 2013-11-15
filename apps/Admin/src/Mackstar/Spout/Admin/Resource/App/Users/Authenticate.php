<?php

namespace Mackstar\Spout\Admin\Resource\App\Users;

use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Annotation\Db;
use BEAR\Sunday\Inject\ResourceInject;
use Mackstar\Spout\Interfaces\SecurityInterface;
use Ray\Di\Di\Inject;

/**
 * Users
 *
 * @Db
 */
class Authenticate extends ResourceObject{

    use DbSetterTrait;
    use ResourceInject;

    protected $table = 'users';
    protected $security;

    /**
     *  @Inject
     */
    public function setSecurity(SecurityInterface $security) {
        $this->security = $security;
        $sql = "SELECT * FROM {$this->table} WHERE `email` = :email";
        $response = $this->db->fetch($sql);
    }

    public function onPost(
    	$email,
    	$password
 	) {
		
        $this->db->('users', [
			'name' => $name,
			'email' => $email,
            'password' => $this->security->encrypt($password)
		]);
        return $this;
    }

}