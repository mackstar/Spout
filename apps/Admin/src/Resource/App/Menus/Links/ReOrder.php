<?php

namespace Mackstar\Spout\Admin\Resource\App\Menus\Links;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * Add
 *
 * @Db
 */
class ReOrder extends ResourceObject {

    use DbSetterTrait;

    private $table = 'links';

    public function onPut($links)
    {
        foreach($links as $link) {
            $this->db->update($this->table, ['weight' => $link['weight']], ['id' => $link['id']]);
        }
    }
} 