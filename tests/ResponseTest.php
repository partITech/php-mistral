<?php

namespace Partitech\PhpMistral\Tests;

use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Response;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testSetAndGetId()
    {
        $response = new Response();
        $response->setId('123');
        $this->assertEquals('123', $response->getId());
    }

    public function testSetAndGetObject()
    {
        $response = new Response();
        $response->setObject('object');
        $this->assertEquals('object', $response->getObject());
    }

    public function testSetAndGetCreated()
    {
        $response = new Response();
        $response->setCreated(1234567890);
        $this->assertEquals(1234567890, $response->getCreated());
    }

    public function testSetAndGetModel()
    {
        $response = new Response();
        $response->setModel('model');
        $this->assertEquals('model', $response->getModel());
    }

    public function testSetAndGetUsage()
    {
        $response = new Response();
        $usage = ['key' => 'value'];
        $response->setUsage($usage);
        $this->assertEquals($usage, $response->getUsage());
    }

    public function testSetAndGetChoices()
    {
        $response = new Response();
        $choices = new \ArrayObject();
        $message = new Message();
        $message->setContent('test');
        $choices->append($message);

        $response->setChoices($choices);
        $this->assertEquals($choices, $response->getChoices());
    }

    public function testAddAndRemoveMessage()
    {
        $response = new Response();
        $message = new Message();
        $message->setContent('test');

        $response->addMessage($message);
        $this->assertEquals(1, $response->getChoices()->count());
    }

    public function testCreateAndUpdateFromArray()
    {
        $data = [
            'id' => '123',
            'object' => 'object',
            'created' => 1234567890,
            'model' => 'model',
            'choices' => [
                ['message' => ['role' => 'user', 'content' => 'Hello']],
                ['delta' => ['role' => 'bot', 'content' => 'Hi']]
            ],
            'usage' => ['key' => 'value']
        ];

        $response = Response::createFromArray($data);
        $this->assertEquals('123', $response->getId());
        $this->assertEquals('object', $response->getObject());
        $this->assertEquals(1234567890, $response->getCreated());
        $this->assertEquals('model', $response->getModel());
        $this->assertEquals(['key' => 'value'], $response->getUsage());
        $this->assertEquals(1, $response->getChoices()->count());

        $data['id'] = '456';
        $updatedResponse = Response::updateFromArray($response, $data);
        $this->assertEquals('456', $updatedResponse->getId());
    }

    public function testGetMessageAndChunk()
    {
        $response = new Response();
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getChunk());

        $message = new Message();
        $message->setContent('Hello');
        $message->setChunk('Chunk1');
        $response->addMessage($message);

        $this->assertEquals('Hello', $response->getMessage());
        $this->assertEquals('Chunk1', $response->getChunk());
    }
}