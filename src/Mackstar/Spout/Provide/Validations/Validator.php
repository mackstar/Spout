<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Provide\Validations;

use Mackstar\Spout\Interfaces\ValidatorInterface;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class Validator implements ValidatorInterface
{
    private $validator;

    public function __construct() {
    	var_dump("validator");
    	$provider = new ValidatorProvider();
    	$this->validators = $provider->get();
    }
}