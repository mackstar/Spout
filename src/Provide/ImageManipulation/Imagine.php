<?php
/**
 * This file is part of the Mackstar.Spout package.
 * 
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Provide\ImageManipulation;

use Mackstar\Spout\Interfaces\ImageManipulationInterface;
use Mackstar\Spout\Interfaces\ImageManipulationProviderInterface;
use Imagine\Imagick\Imagine as ImagickImagine;
use Imagine\Gd\Imagine as GdImagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;

class Imagine implements ImageManipulationInterface
{

    protected $imagine;

    public function __construct()
    {
        if (extension_loaded('imagick')) {
            $this->imagine = new ImagickImagine();
            return;
        }

        if (class_exists('\\Gmagick')) {
            $this->imagine =  new GmagickImagine();
            return;
        }

        $this->imagine = new GdImagine();
    }


    public function resize($source, $target, $width, $height)
    {
        $image = $this->imagine->open($source);
        $box = new Box($width, $height);
        //$image->resize(new Box($width, $height));
        //$image->save($target);

        $srcBox = $image->getSize();
        if ($srcBox->getWidth() > $srcBox->getHeight()) {
            $width  = $srcBox->getWidth()*($box->getHeight()/$srcBox->getHeight());
            $height =  $box->getHeight();
            $cropPoint = new Point((max($width - $box->getWidth(), 0)) / 2, 0);
        } else {
            $width  = $box->getWidth();
            $height =  $srcBox->getHeight() * ($box->getWidth() / $srcBox->getWidth());
            $cropPoint = new Point(0, (max($height - $box->getHeight(), 0)) / 2);
        }
        $tempBox = new Box($width, $height);
        $image = $image->thumbnail($tempBox, ImageInterface::THUMBNAIL_OUTBOUND);
        $image->crop($cropPoint, $box)->save($target);
    }
} 