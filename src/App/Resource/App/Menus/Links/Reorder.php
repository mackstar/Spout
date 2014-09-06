<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Menus\Links;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * Add
 *
 * @Db
 */
class Reorder extends ResourceObject
{
    use DbSetterTrait;

    private $table = 'links';

    public function onPut($links)
    {
        foreach($links as $link) {
            $this->db->update($this->table, ['weight' => $link['weight']], ['id' => $link['id']]);
        }
    }
}
