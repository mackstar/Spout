<?php

namespace Mackstar\Spout\Admin\Resource\App\Users;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * Users
 *
 * @Db
 */
class Index extends ResourceObject{

    use DbSetterTrait;

    protected $table = 'users';

    public function onGet($email = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        $this['users'] = $this->db->fetchAll($sql);
        return $this;
    }

    public function onPost(
    	$email,
    	$name
 	) {
		$this->db->insert('users', [
			'name' => $name,
			'email' => $email,
		]);
        return $this;
    }

}