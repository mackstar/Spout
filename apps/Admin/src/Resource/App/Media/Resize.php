<?php

namespace Mackstar\Spout\Admin\Resource\App\Media;

use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Mackstar\Spout\Interfaces\ImageManipulationInterface;

class Resize extends ResourceObject
{
    protected $table = 'media';

    protected $imageManipulator;

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
     * @param ImageManipulationInterface $imageManipulator
     *
     * @Inject
     */
    public function setImageManipulator(ImageManipulationInterface $imageManipulator)
    {
        $this->imageManipulator = $imageManipulator;
    }

    public function onPost($media, $width, $height)
    {
        $targetDir = $this->uploadDir . '/media/' . $media['directory'];
        $source = $targetDir . '/' . $media['file'];
        $target = "{$targetDir}/{$width}x{$height}_{$media['file']}";
        $this->imageManipulator->resize($source, $target, $width, $height);
        return $this;
    }
}
