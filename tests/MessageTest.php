<?php

namespace Partitech\PhpMistral\Tests;

use Partitech\PhpMistral\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testRole()
    {
        $message = new Message();
        $this->assertNull($message->getRole());

        $message->setRole('user');
        $this->assertEquals('user', $message->getRole());
    }

    public function testContent()
    {
        $message = new Message();
        $this->assertNull($message->getContent());

        $message->setContent('content1');
        $this->assertEquals('content1', $message->getContent());
    }

    public function testUpdateContent()
    {
        $message = new Message();
        $this->assertNull($message->getContent());

        $message->setContent('content1');
        $this->assertEquals('content1', $message->getContent());

        $message->updateContent('content2');
        $this->assertEquals('content1content2', $message->getContent());
    }


    public function testChunk()
    {
        $message = new Message();
        $this->assertIsString($message->getChunk());

        $message->setChunk('content1');
        $this->assertEquals('content1', $message->getChunk());
    }

}