<?php

namespace Partitech\PhpMistral\Tests\Tools;

use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Tools\Tool;
use Partitech\PhpMistral\Tools\FunctionTool;

class ToolTest extends TestCase
{
    public function testHappyPath()
    {
        $functionTool = $this->createMock(FunctionTool::class);
        $type = 'exampleType';

        $tool = new Tool($type, $functionTool);

        $this->assertEquals($type, $tool->type);
        $this->assertInstanceOf(FunctionTool::class, $tool->function);
    }

    public function testTypeIsEmptyString()
    {
        $functionTool = $this->createMock(FunctionTool::class);
        $type = '';

        $this->expectException(\TypeError::class);
        new Tool($type, $functionTool);
    }

    public function testFunctionIsNotFunctionTool()
    {
        $this->expectException(\TypeError::class);
        new Tool('exampleType', new \stdClass());
    }
}
