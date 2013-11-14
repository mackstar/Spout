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
class Index extends ResourceObject{

    use DbSetterTrait;

    protected $table = 'users';
    protected $security;

    /**
     *  @Inject
     */
    public function setSecurity(SecurityInterface $security) {
        $this->security = $security;
    }

    public function onGet($email = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        $this['users'] = $this->db->fetchAll($sql);
        return $this;
    }

    public function onPost(
    	$email,
    	$name,
        $password
 	) {
		
        $this->db->insert('users', [
			'name' => $name,
			'email' => $email,
            'password' => $this->security->encrypt($password)
		]);
        return $this;
    }

}