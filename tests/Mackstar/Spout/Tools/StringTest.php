<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Tools;

use Mackstar\Spout\Tools\String;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class StringTest extends \PHPUnit_Framework_TestCase
{

    public function testInstanciationOfString() {
        $string = new String();
        $this->assertTrue($string instanceof String);
    }

    public function testInstanciationOfStringWithConstructor() {
        $string = new String('string');
        $this->assertEquals($string->getString(), 'string');
    }

    public function testSettingOfString() {
        $string = new String();
        $string->setString('string');
        $this->assertEquals($string->getString(), 'string');
    }

    public function testAlreadySingularizedValue() {
        $string = new String();
        $result = $string->singularize('string');
        $this->assertEquals($result, 'string');
    }

    public function testReturnsStringSetInConstructor() {
        $string = new String('string');
        $result = $string->singularize();
        $this->assertEquals($result, 'string');
    }

    public function testReturnsSingularizedString() {
        $string = new String('roles');
        $result = $string->singularize();
        $this->assertEquals($result, 'role');
    }
}
