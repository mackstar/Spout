<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Indexes;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Sunday\Inject\ResourceInject;
use PDO;

/**
 * FieldTypes
 *
 * @Db
 */
class Index extends ResourceObject
{
    use DbSetterTrait;
    use ResourceInject;


    protected $table = 'indexes';
    protected $urisTable = 'index_uris';

    public function onGet($slug = null)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select('i.*')
            ->from($this->table, 'i');

        if (!is_null($slug)) {
            $queryBuilder->where('i.slug = :slug')
                ->setParameter('slug', $slug);
            $this['uris'] = $this->resource->get->uri('app://spout/indexes/uris')
                ->eager
                ->withQuery(['index' => $slug])
                ->request();
        }

        $stmt = $queryBuilder->execute();
        $this['index'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this;
    }

    public function onPost($slug, $title, $uris = [])
    {
        $this->db->insert($this->table, [
            'slug' => $slug,
            'title' => $title
        ]);
        return $this;
    }

}
