<?php

namespace Mackstar\Spout\Admin\Resource\App\Media;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
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
     * @Named("upload_dir")
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
        $file
    ) {
        if (!$file['error'] && is_uploaded_file($file['tmp_name'])) {

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
        }

        $media = [
            'uuid' => $uuid,
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

    public function onGet()
    {
        $sql = "SELECT * FROM {$this->table}";
        $this['media'] = $this->db->fetchAll($sql);
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

    public function onPut($uuid, $title)
    {
        $this->db->update($this->table, ['title' => $title], ['uuid' => $uuid]);
        return $this;
    }

}
