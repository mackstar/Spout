<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Media;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use PDO;

/**
 * Add
 *
 * @Db
 */
class Folders extends ResourceObject
{

    use DbSetterTrait;

    protected $table = 'media_folders';

    public function onPost(
        $parent,
        $name
    ) {
        $this->db->insert($this->table, [
            'parent' => $parent,
            'name' => $name
        ]);
    }

    public function onGet($parent = '0')
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select('i.*')
            ->from($this->table, 'i')
            ->where('i.parent = :parent')
            ->setParameter('parent', $parent);

        $this['folders'] = $queryBuilder->execute()->fetchAll();
        return $this;
    }
}
