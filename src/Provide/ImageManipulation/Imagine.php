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

    /**
     * Contrsuructor choosing either imagick or gmagick depending
     * on availability.
     *
     */
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

    /**
     *
     *
     */
    public function resize($source, $target, $width, $height, $crop = 'center')
    {
        $image = $this->imagine->open($source);
        $box = new Box($width, $height);
        $srcBox = $image->getSize();

        $heightBasedWidth = $srcBox->getWidth()*($box->getHeight()/$srcBox->getHeight());

        if (
            $srcBox->getWidth() > $srcBox->getHeight() &&
            $heightBasedWidth >= $width
        ){
            $width  = $heightBasedWidth;
            $height =  $box->getHeight();
            $cropPoint = new Point((max($width - $box->getWidth(), 0)) / 2, 0);
        } else {
            $width  = $box->getWidth();
            $height =  ceil($srcBox->getHeight() * ($box->getWidth() / $srcBox->getWidth()));
            if ($crop == 'top') {
                $cropPoint = new Point(0, 0);
            }
            if ($crop == 'center') {
                $cropPoint = new Point(0, (max($height - $box->getHeight(), 0)) / 2);
            }

        }

        $tempBox = new Box($width, $height);
        $image = $image->thumbnail($tempBox, ImageInterface::THUMBNAIL_INSET);
        $image->crop($cropPoint, $box)->save($target);
    }
}
