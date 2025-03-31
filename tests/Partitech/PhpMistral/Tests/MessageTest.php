<?php

namespace Partitech\PhpMistral\Tests;

use Partitech\PhpMistral\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testSetRoleAndGetRole()
    {
        $message = new Message();
        $message->setRole('user');
        $this->assertEquals('user', $message->getRole());
    }

    public function testSetContentAndGetContent()
    {
        $message = new Message();
        $message->setContent('Hello World');
        $this->assertEquals('Hello World', $message->getContent());
    }

    public function testUpdateContentString()
    {
        $message = new Message();
        $message->setContent('Hello ');
        $message->updateContent('World');
        $this->assertEquals('Hello World', $message->getContent());
    }

    public function testUpdateContentArray()
    {
        $message = new Message();
        $message->setContent(['part1']);
        $message->updateContent('part2');
        $this->assertEquals(['part1', 'part2'], $message->getContent());
    }

    public function testSetChunkAndGetChunk()
    {
        $message = new Message();
        $message->setChunk('test chunk');
        $this->assertEquals('test chunk', $message->getChunk());
    }

    public function testAddTextContent()
    {
        $message = new Message();
        $message->addContent(Message::MESSAGE_TYPE_TEXT, 'Sample text');
        $expected = [
            ['type' => 'text', 'text' => 'Sample text']
        ];
        $this->assertEquals($expected, $message->getContent());
    }

    public function testAddImageUrlContent()
    {
        $message = new Message();
        $message->addContent(Message::MESSAGE_TYPE_IMAGE_URL, 'http://example.com/image.jpg');
        $expected = [
            ['type' => 'image_url', 'image_url' => ['url' => 'http://example.com/image.jpg']]
        ];
        $this->assertEquals($expected, $message->getContent());
    }

    public function testAddVideoUrlContent()
    {
        $message = new Message();
        $message->addContent(Message::MESSAGE_TYPE_VIDEO_URL, 'http://example.com/video.mp4');
        $expected = [
            ['type' => 'video_url', 'video_url' => ['url' => 'http://example.com/video.mp4']]
        ];
        $this->assertEquals($expected, $message->getContent());
    }

    public function testAddAudioUrlContent()
    {
        $message = new Message();
        $message->addContent(Message::MESSAGE_TYPE_AUDIO_URL, 'http://example.com/audio.mp3');
        $expected = [
            ['type' => 'audio_url', 'audio_url' => ['url' => 'http://example.com/audio.mp3']]
        ];
        $this->assertEquals($expected, $message->getContent());
    }

    public function testAddDocumentUrlContent()
    {
        $message = new Message();
        $message->addContent(Message::MESSAGE_TYPE_DOCUMENT_URL, 'http://example.com/document.pdf');
        $expected = [
            ['type' => 'document_url', 'document_url' => 'http://example.com/document.pdf']
        ];
        $this->assertEquals($expected, $message->getContent());
    }

    public function testAddBase64ContentWithValidImageFile()
    {
        $message = new Message();
    }
}
