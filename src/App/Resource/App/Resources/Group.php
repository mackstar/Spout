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
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Resource\Annotation\Link;
use BEAR\Sunday\Annotation\DbPager;
use Mackstar\Spout\Provide\Resource\FieldMapperTrait;
use Mackstar\Spout\Provide\Resource\UserIdSetterTrait;
use Mackstar\Spout\App\Annotation\UserIdInject;
use PDO;

/**
 * Resources Index
 *
 * @Db
 * @UserIdInject
 */
class Group extends ResourceObject
{
    use DbSetterTrait;
    use ResourceInject;
    use FieldMapperTrait;

    protected $table = 'resources';

    public function onGet($type, $slugs)
    {
        // Get resources list (title/meta)
        // Get resource_fields from $type order by weight
        // Get field_values by (table name) where resource_ids in ids
        // Map fields to retrieved fields
        return $this;
    }
}