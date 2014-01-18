<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Interfaces;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
interface StringInterface
{
    public function singularize($string = null);

    public function setString($string);
}
