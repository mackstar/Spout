<?php

namespace Mackstar\Spout;

class SpoutTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Spout
     */
    protected $skeleton;

    protected function setUp()
    {
        $this->skeleton = new Spout;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\Mackstar\Spout\Spout', $actual);
    }

    /**
     * @expectedException \Mackstar\Spout\Exception\LogicException
     */
    public function testException()
    {
        throw new Exception\LogicException;
    }
}
