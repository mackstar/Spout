<?php

namespace Mackstar\Spout\Admin\Resource\Page;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

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
        $this['users'] = $this->db->fetchAll($sql);
        $this['title'] = 'my title';

        return $this;
    }
}