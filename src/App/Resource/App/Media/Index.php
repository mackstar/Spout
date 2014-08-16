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

use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use BEAR\Sunday\Inject\ResourceInject;
use Mackstar\Spout\Provide\Resource\ResourceObject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Rhumsaa\Uuid\Uuid;

/**
 * Add
 *
 * @Db
 */
class Index extends ResourceObject
{

    use DbSetterTrait;
    use ResourceInject;

    protected $table = 'media';

    protected $uploadDir;

    protected $uuid;

    /**
     * @param Uuid $uuid
     *
     * @Inject
     */
    public function setUuid(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param $uploadDir
     *
     * @Inject
     * @Named("uploadDir=upload_dir")
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    /**
     * @param $file
     * @return $this
     * @throws \Exception
     */
    public function onPost(
        $file,
        $folder
    ) {
        if ($file['error'] || !is_uploaded_file($file['tmp_name'])) {
            return $this->resource->get->uri('app://spout/exceptions/mediaupload')
                ->eager
                ->request();
        }

        $uuid = (string) $this->uuid;
        $uuidDir = substr($uuid, 0, 2);
        $targetDir = $this->uploadDir . '/media/' . $uuidDir;
        $fileName = $uuid. '_' . $file['name'];
        $target = $targetDir . '/' . $fileName;
        $suffix = pathinfo($fileName, PATHINFO_EXTENSION);


        if (!is_dir($targetDir)) {
            mkdir($targetDir);
        }

        if (!@move_uploaded_file($file['tmp_name'], $target)) {
            $error = error_get_last();
            throw new \Exception(sprintf(
                'Could not move the file "%s" to "%s" (%s)',
                $file['tmp_name'],
                $target,
                strip_tags($error['message'])
            ));
        }

        @chmod($target, 0666 & ~umask());

        $media = [
            'uuid' => $uuid,
            'folder' => $folder,
            'directory' => $uuidDir,
            'file' => $fileName,
            'type' => 'media',
            'suffix' => $suffix
        ];

        $this->db->insert($this->table, $media);

        $this['media'] = $media;
        $this['_model'] = 'media';

        return $this;
    }

    public function onGet($uuid = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        if (is_null($uuid)) {
            $this['media'] = $this->db->fetchAll($sql);
        }
        if (!is_null($uuid)) {
            $sql .= " WHERE uuid = :uuid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('uuid', $uuid);
            $stmt->execute();
            $this['media'] = $stmt->fetch();
        }
        return $this;
    }

    public function onPut($uuid, $title)
    {
        $this->db->update($this->table, ['title' => $title], ['uuid' => $uuid]);
        return $this;
    }

}
