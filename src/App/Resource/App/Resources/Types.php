<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Resources;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Sunday\Annotation\Transactional;

/**
 * PropertyTypes
 *
 * @Db
 */
class Types extends ResourceObject
{

    use DbSetterTrait;

    protected $table = 'resource_types';
    protected $resourceFieldsTable = 'resource_fields';

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

            $sql = "SELECT * FROM `{$this->resourceFieldsTable}` WHERE `resource_type` = :slug ORDER BY `weight`";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('slug', $slug);
            $stmt->execute();
            $this->body['type']['fields'] = $stmt->fetchAll();
        }
        return $this;
    }


    /**
     * @Transactional
     */
    public function onPost($name, $slug, $title_label, $resource_fields)
    {
        $this->db->beginTransaction();

        try {
            $this->db->insert('resource_types', compact(['name', 'slug', 'title_label']));
            foreach ($resource_fields as $resource_field) {
                $resource_field['field_type'] = $resource_field['field_type']['slug'];
                $resource_field['resource_type'] = $slug;
                $this->db->insert('resource_fields', $resource_field);
            }
            $this->db->commit();

        } catch (\Exception $e) {
            $this->db->rollback();
            echo $e->getMessage();
            exit;
        }

        return $this;
    }

    public function onDelete($slug)
    {

        $this->db->delete($this->table, ['slug' => $slug]);
        $this->db->delete($this->resourceFieldsTable, ['resource_type' => $slug]);
        $this->code = 204;
        return $this;
    }

}
