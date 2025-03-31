<?php

namespace Partitech\PhpMistral\Tests\Tools;

use Partitech\PhpMistral\Tools\Parameter;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{

    public function testConstructorSetsDefaultValues()
    {
        $parameter = new Parameter();
        $this->assertEquals('string', $parameter->getType());
        $this->assertNull($parameter->getName());
        $this->assertNull($parameter->getDescription());
        $this->assertFalse($parameter->isRequired());
    }

    public function testConstructorSetsProvidedValues()
    {
        $parameter = new Parameter('integer', 'age', 'Age of the user', true);
        $this->assertEquals('integer', $parameter->getType());
        $this->assertEquals('age', $parameter->getName());
        $this->assertEquals('Age of the user', $parameter->getDescription());
        $this->assertTrue($parameter->isRequired());
    }

    public function testSetTypeAndGetTypeName()
    {
        $parameter = new Parameter();
        $parameter->setType('boolean');
        $this->assertEquals('boolean', $parameter->getType());
    }

    public function testSetNameAndGetName()
    {
        $parameter = new Parameter();
        $parameter->setName('username');
        $this->assertEquals('username', $parameter->getName());
    }

    public function testSetDescriptionAndGetDescription()
    {
        $parameter = new Parameter();
        $parameter->setDescription('The username of the user');
        $this->assertEquals('The username of the user', $parameter->getDescription());
    }

    public function testSetRequiredAndGetRequired()
    {
        $parameter = new Parameter();
        $parameter->setRequired(true);
        $this->assertTrue($parameter->isRequired());
    }

    // Edge case tests
    public function testConstructorWithNullValues()
    {
        $parameter = new Parameter(null, null, null, false);
        $this->assertEquals('string', $parameter->getType());
        $this->assertNull($parameter->getName());
        $this->assertNull($parameter->getDescription());
        $this->assertFalse($parameter->isRequired());
    }

    public function testConstructorWithEmptyStringValues()
    {
        $parameter = new Parameter('', '', '', false);
        $this->assertEquals('', $parameter->getType());
        $this->assertEquals('', $parameter->getName());
        $this->assertEquals('', $parameter->getDescription());
        $this->assertFalse($parameter->isRequired());
    }

    public function testConstructorWithBooleanFalse()
    {
        $parameter = new Parameter(null, null, null, false);
        $this->assertFalse($parameter->isRequired());
    }

    public function testConstructorWithBooleanTrue()
    {
        $parameter = new Parameter(null, null, null, true);
        $this->assertTrue($parameter->isRequired());
    }

    public function testSetTypeWithEmptyString()
    {
        $parameter = new Parameter();
        $parameter->setType('');
        $this->assertEquals('', $parameter->getType());
    }

    public function testSetTypeString()
    {
        $parameter = new Parameter();
        $parameter->setType('string');
        $this->assertEquals('string', $parameter->getType());
    }

    public function testSetNameWithEmptyString()
    {
        $parameter = new Parameter();
        $parameter->setName('');
        $this->assertEquals('', $parameter->getName());
    }

    public function testSetDescriptionWithEmptyString()
    {
        $parameter = new Parameter();
        $parameter->setDescription('');
        $this->assertEquals('', $parameter->getDescription());
    }

    public function testSetRequiredWithFalse()
    {
        $parameter = new Parameter();
        $parameter->setRequired(false);
        $this->assertFalse($parameter->isRequired());
    }

    public function testSetRequiredWithTrue()
    {
        $parameter = new Parameter();
        $parameter->setRequired(true);
        $this->assertTrue($parameter->isRequired());
    }
}
