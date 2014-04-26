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

    protected $table = 'menus';

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

            $uuid = $this->uuid;

            $targetDir = $this->uploadDir . '/media/' . $uuid;
            $target = $targetDir . '/' . $file['name'];
            mkdir($targetDir);

            if (!@move_uploaded_file($file['tmp_name'], $target)) {
                $error = error_get_last();
                throw new \Exception(sprintf('Could not move the file "%s" to "%s" (%s)', $file['tmp_name'], $target, strip_tags($error['message'])));
            }


            @chmod($target, 0666 & ~umask());
        }

        return $this;
    }

}