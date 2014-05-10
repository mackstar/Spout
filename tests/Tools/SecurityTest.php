<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Tools;

use Mackstar\Spout\Tools\Security;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class SecurityTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateSaltContainsStringLongerThanFiveCharacters()
    {
        $security = new Security;
        $salt = $security->createSalt();
        $this->assertTrue(strlen($salt) > 5);
    }

    public function testCreatedSaltIsNotTheSameTwice()
    {
        $security = new Security;
        $salt1 = $security->createSalt();
        $salt2 = $security->createSalt();
        $this->assertTrue($salt1 != $salt2);
    }

    public function testCanCreateAHashWithNoSalt()
    {
        $security = new Security;
        $password = 'secret';
        $hash = $security->encrypt($password);
        $this->assertTrue($hash != $password);
        $this->assertTrue($hash != crypt($password, null));
    }

    public function testCanCreateAHashWithSalt()
    {
        $security = new Security;
        $password = 'secret';
        $salt = 'salt';
        $hash = $security->encrypt($password, $salt);
        $this->assertEquals(crypt($password, $salt), $hash);
    }

    public function testGetAPasswordMatch()
    {
        $security = new Security;
        $password = 'secret';
        $hash = $security->encrypt($password);
        $this->assertTrue($security->match($password, $hash));
    }

    public function testPasswordsDontMatch()
    {
        $security = new Security;
        $password = 'secret';
        $hash = $security->encrypt($password);
        $this->assertFalse($security->match('somethingelse', $hash));
    }
}
