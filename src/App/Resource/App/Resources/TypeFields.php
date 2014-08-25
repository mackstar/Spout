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
class Typefields extends ResourceObject
{

    use DbSetterTrait;

    private $table = 'resource_type';

    /**
     * @Transactional
     */
    public function onPost($resource_type, $field_type, $label, $slug, $multiple, $weight)
    {

        $this->db->insert(
            'resource_fields',
            compact('resource_type', 'field_type', 'label', 'slug', 'multiple', 'weight')
        );
    }

    public function onDelete($slug)
    {

        $this->db->delete($this->table, ['slug' => $slug]);
        $this->code = 204;
        return $this;
    }

}
