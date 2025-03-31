<?php

namespace Partitech\PhpMistral\Tests;

use DateMalformedStringException;
use Partitech\PhpMistral\File;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use DateTime;

class FileTest extends TestCase
{
    // Happy path test case
    public function testFromResponse()
    {
        $response = [
            'id' => '123e4567-e89b-12d3-a456-426614174000',
            'object' => 'file',
            'created_at' => time(),
            'bytes' => 1024,
            'filename' => 'test.txt',
            'purpose' => 'example',
            'sample_type' => 'sample',
            'num_lines' => 10,
            'source' => 'local',
        ];

        $file = File::fromResponse($response);

        $this->assertInstanceOf(File::class, $file);
        $this->assertInstanceOf(UuidInterface::class, $file->getId());
        $this->assertEquals('123e4567-e89b-12d3-a456-426614174000', $file->getId()->toString());
        $this->assertEquals('file', $file->getObject());
        $this->assertInstanceOf(DateTime::class, $file->getCreatedAt());
        $this->assertEquals($response['bytes'], $file->getBytes());
        $this->assertEquals($response['filename'], $file->getFilename());
        $this->assertEquals($response['purpose'], $file->getPurpose());
        $this->assertEquals($response['sample_type'], $file->getSampleType());
        $this->assertEquals($response['num_lines'], $file->getNumLines());
        $this->assertEquals($response['source'], $file->getSource());
    }


    /**
     * @throws DateMalformedStringException
     */
    public function testFromResponseNumLinesNull()
    {
        $response = [
            'id' => '123e4567-e89b-12d3-a456-426614174001',
            'object' => 'file',
            'created_at' => time(),
            'bytes' => 2048,
            'filename' => 'test2.txt',
            'purpose' => 'example2',
            'sample_type' => 'sample2',
            'num_lines' => null,
            'source' => 'local2',
        ];

        $file = File::fromResponse($response);

        $this->assertNull($file->getNumLines());
    }

    // Edge case: created_at is a string that can be converted to a DateTime

    /**
     * @throws DateMalformedStringException
     */
    public function testFromResponseCreatedAtString()
    {
        $timestamp = time();
        $response = [
            'id' => '123e4567-e89b-12d3-a456-426614174002',
            'object' => 'file',
            'created_at' => $timestamp,
            'bytes' => 3072,
            'filename' => 'test3.txt',
            'purpose' => 'example3',
            'sample_type' => 'sample3',
            'num_lines' => 20,
            'source' => 'local3',
        ];

        $file = File::fromResponse($response);

        $this->assertInstanceOf(DateTime::class, $file->getCreatedAt());
        $this->assertEquals(date('Y-m-d H:i:s', $timestamp), $file->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    public function testFromResponseInvalidCreatedAt()
    {
        $this->expectException(DateMalformedStringException::class);

        $response = [
            'id' => '123e4567-e89b-12d3-a456-426614174003',
            'object' => 'file',
            'created_at' => 'invalid_timestamp',
            'bytes' => 4096,
            'filename' => 'test4.txt',
            'purpose' => 'example4',
            'sample_type' => 'sample4',
            'num_lines' => 30,
            'source' => 'local4',
        ];

        File::fromResponse($response);
    }

    // Edge case: id is not a valid UUID
    public function testFromResponseInvalidId()
    {
        $this->expectException(\InvalidArgumentException::class);

        $response = [
            'id' => 'invalid_uuid',
            'object' => 'file',
            'created_at' => time(),
            'bytes' => 5120,
            'filename' => 'test5.txt',
            'purpose' => 'example5',
            'sample_type' => 'sample5',
            'num_lines' => 40,
            'source' => 'local5',
        ];

        File::fromResponse($response);
    }

    // Edge case: bytes is negative
    public function testFromResponseNegativeBytes()
    {
        $this->expectException(\InvalidArgumentException::class);

        $response = [
            'id' => '123e4567-e89b-12d3-a456-426614174004',
            'object' => 'file',
            'created_at' => time(),
            'bytes' => -1024,
            'filename' => 'test6.txt',
            'purpose' => 'example6',
            'sample_type' => 'sample6',
            'num_lines' => 50,
            'source' => 'local6',
        ];

        File::fromResponse($response);
    }

    public function testFromResponseNegativeNumLines()
    {
        $this->expectException(\InvalidArgumentException::class);

        $response = [
            'id' => '123e4567-e89b-12d3-a456-426614174005',
            'object' => 'file',
            'created_at' => time(),
            'bytes' => 6144,
            'filename' => 'test7.txt',
            'purpose' => 'example7',
            'sample_type' => 'sample7',
            'num_lines' => -60,
            'source' => 'local7',
        ];

        File::fromResponse($response);
    }
}
