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
use PDO;

/**
 * FieldTypes
 *
 * @Db
 */
class Resourcefields extends ResourceObject
{
    use DbSetterTrait;

    protected $table = 'resource_fields';

    public function onGet($type, $slug = null)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('r.*')
            ->from($this->table, 'r')
            ->where('r.resource_type = ?')
            ->setParameter(0, $type);

        if (!is_null($slug)) {
            $slugs = (array) $slug;
            $orX = $qb->expr()->orX();
            for ($i=0; $i < count($slugs); $i++) { 
                $orX->add('r.slug = ?');
                $qb->setParameter($i + 1, $slugs[$i]);
            }
            $qb->andWhere($orX);
        }

        $stmt = $qb->execute();
        $this['resource_fields'] = $stmt->fetchAll();

        return $this;
    }

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
