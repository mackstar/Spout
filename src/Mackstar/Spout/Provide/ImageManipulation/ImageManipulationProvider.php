<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Provide\ImageManipulation;

use Mackstar\Spout\Interfaces\ImageManipulationProviderInterface;

class ImageManipulationProvider implements ImageManipulationProviderInterface
{

    public function get()
    {
        if (extension_loaded('imagick')) {
            return new \Imagine\Imagick\Imagine();
        }

        if (class_exists('\\Gmagick')) {
            return new \Imagine\Imagick\Imagine();
        }

        return \Imagine\Gd\Imagine();
    }

} 