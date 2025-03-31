<?php
namespace Partitech\PhpMistral\Tests\Tools;

use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\Parameter;

class FunctionToolTest extends TestCase
{
    public function testConstructorInitializesPropertiesCorrectly(): void
    {
        $param = new Parameter('username', 'string', 'The user name', true);
        $tool = new FunctionTool('UserFunction', 'Handles user data', [$param]);

        $this->assertEquals('UserFunction', $tool->name);
        $this->assertEquals('Handles user data', $tool->description);
        $this->assertArrayHasKey('properties', $tool->parameters);
        $this->assertArrayHasKey('required', $tool->parameters);
        $this->assertArrayHasKey('type', $tool->parameters);
        $this->assertEquals('object', $tool->parameters['type']);
    }

    public function testConstructorThrowsExceptionOnInvalidParameter(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FunctionTool('InvalidTool', 'Desc', ['not_a_parameter']);
    }


    public function testAddParameterAddsRequiredParameter(): void
    {
        $tool = new FunctionTool('ReqTool', 'Description', []);
        $param = new Parameter('email', 'string', 'Email address', true);
        $tool->addParameter($param);

        $this->assertEquals('Email address', $tool->parameters['properties']['string']['description']);
        $this->assertEquals('email', $tool->parameters['properties']['string']['type']);
        $this->assertEquals('string', $tool->parameters['required'][0]);
    }
}
