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
class Listing extends ResourceObject
{

    use DbSetterTrait;

    protected $table = 'media';


    public function onGet($folder = 0)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select('m.*')
             ->from($this->table, 'm');
 
        $queryBuilder->where('m.folder = :folder')
            ->setParameter('folder', $folder);

        $stmt = $queryBuilder->execute();
        $this['_model'] = 'media';
        $this['media'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this;
    }

    public function onDelete($uuid, $directory)
    {
        $dir = $this->uploadDir . '/media/' . $directory;
        $files = scandir($dir);
        foreach ($files as $file) {
            if (strpos($file, $uuid) !== false) {
                unlink($dir. '/' . $file);
            }
        }
        $files = scandir($dir);
        if (count($files) === 0) {
            rmdir($dir);
        }

        $this->db->delete($this->table, ['uuid' => $uuid]);
        $this->code = 204;
    }
}
