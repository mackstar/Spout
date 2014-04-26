<?php

namespace Mackstar\Spout\Admin\Resource\App\Media;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

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

            $guid = $conn->fetchColumn('SELECT ' . $conn->getDatabasePlatform()->getGuidExpression());

            $target = __DIR__ . '/../../../../var/www/uploads/' . $file['name'];

            if (!@move_uploaded_file($file['tmp_name'], $target)) {
                $error = error_get_last();
                throw new \Exception(sprintf('Could not move the file "%s" to "%s" (%s)', $file['tmp_name'], $target, strip_tags($error['message'])));
            }


            @chmod($target, 0666 & ~umask());
        }
        var_dump($file);

        return $this;
    }

}