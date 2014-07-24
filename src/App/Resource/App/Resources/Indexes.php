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

/**
 * FieldTypes
 *
 * @Db
 */
class Indexes extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'resource_indexes';

    public function onGet($slug = null)
    {

        $sql  = "SELECT {$this->table}.* FROM {$this->table} ";
        $this['indexes'] = $this->db->fetchAll($sql);

        return $this;
    }

    public function onPost($slug = null)
    {

        $sql  = "SELECT {$this->table}.* FROM {$this->table} ";
        $this['indexes'] = $this->db->fetchAll($sql);

        return $this;
    }

    public function paginated() {

    }

    public function nonPaginated() {
        
    }

}
