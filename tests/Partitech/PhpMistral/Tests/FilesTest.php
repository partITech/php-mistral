<?php

namespace Partitech\PhpMistral\Tests;

use ArrayIterator;
use ArrayObject;
use Partitech\PhpMistral\Files;
use Partitech\PhpMistral\File;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testAddAndRetrieveFiles()
    {
        $files = new Files();
        $file1 = new File('file1.txt');
        $file2 = new File('file2.txt');

        $files->addFile($file1);
        $files->addFile($file2);

        $retrievedFiles = $files->getFiles();
        $this->assertInstanceOf(ArrayObject::class, $retrievedFiles);
        $this->assertCount(2, $retrievedFiles);
        $this->assertEquals($file1, $retrievedFiles[0]);
        $this->assertEquals($file2, $retrievedFiles[1]);
    }

    /**
     * Test setting files with an empty ArrayObject.
     */
    public function testSetFilesWithEmptyArrayObject()
    {
        $files = new Files();
        $emptyFiles = new ArrayObject();

        $files->setFiles($emptyFiles);

        $this->assertEquals($emptyFiles, $files->getFiles());
    }

    /**
     * Test setting files with an ArrayObject containing files.
     */
    public function testSetFilesWithArrayObjectContainingFiles()
    {
        $files = new Files();
        $file1 = new File('file1.txt');
        $file2 = new File('file2.txt');
        $filesArrayObject = new ArrayObject([$file1, $file2]);

        $files->setFiles($filesArrayObject);

        $this->assertEquals($filesArrayObject, $files->getFiles());
    }

    /**
     * Test the iterator when no files are added.
     */
    public function testIteratorWithNoFiles()
    {
        $files = new Files();

        $iterator = $files->getIterator();
        $this->assertInstanceOf(ArrayIterator::class, $iterator);
        $this->assertFalse($iterator->valid());
    }

    /**
     * Test the iterator when files are added.
     */
    public function testIteratorWithFiles()
    {
        $files = new Files();
        $file1 = new File('file1.txt');
        $file2 = new File('file2.txt');

        $files->addFile($file1);
        $files->addFile($file2);

        $iterator = $files->getIterator();
        $this->assertInstanceOf(ArrayIterator::class, $iterator);
        $this->assertTrue($iterator->valid());
        $this->assertEquals($file1, $iterator->current());
        $iterator->next();
        $this->assertEquals($file2, $iterator->current());
        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
