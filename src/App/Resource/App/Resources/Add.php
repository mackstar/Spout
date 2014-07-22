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

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * Add
 *
 * @Db
 */
class Add extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'field_types';

    public function onGet()
    {

        $sql  = "SELECT {$this->table}.* FROM {$this->table} ";
        $this['resources'] = $this->db->fetchAll($sql);

        return $this;
    }


}
