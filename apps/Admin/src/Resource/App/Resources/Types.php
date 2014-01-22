<?php

namespace Mackstar\Spout\Admin\Resource\App\Resources;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * PropertyTypes
 *
 * @Db
 */
class Types extends ResourceObject{

    use DbSetterTrait;

    protected $table = 'resource_types';

    public function onGet($slug = null)
    {
        $sql = "SELECT * FROM {$this->table}";

        if (is_null($slug)) {
            $this['types'] = $this->db->fetchAll($sql);
        } else {
            $sql .= " WHERE slug = :slug";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('slug', $slug);
            $stmt->execute();
            $this['type'] = $stmt->fetch();
        }

        return $this;
    }
}