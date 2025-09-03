<?php

namespace Tests\Units\Chunk;


use InvalidArgumentException;
use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Chunk\ChunkCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @covers \Partitech\PhpMistral\Chunk\Chunk
 * @uses   \Partitech\PhpMistral\Chunk\ChunkCollection
 */
final class ChunkTest extends TestCase
{
    public function testConstructorNormalizesNullTextAndGeneratesUuid(): void
    {
        // When text is null, it should be normalized to empty string.
        $chunk = new Chunk(null);

        $this->assertSame('', $chunk->getText(), 'Null text must be normalized to empty string.');

        // A UUID should be auto-generated and valid.
        $uuid = $chunk->getUuid();
        $this->assertIsString($uuid);
        $this->assertTrue(Uuid::isValid($uuid), 'Auto-generated UUID should be valid.');
    }

    public function testConstructorKeepsProvidedValidUuid(): void
    {
        $providedUuid = Uuid::uuid7()->toString();

        $chunk = new Chunk('hello', [
            Chunk::METADATA_KEY_UUID => $providedUuid,
        ]);

        $this->assertSame($providedUuid, $chunk->getUuid(), 'Constructor should keep a valid provided UUID.');
    }

    public function testConstructorReplacesInvalidProvidedUuid(): void
    {
        $chunk = new Chunk('hello', [
            Chunk::METADATA_KEY_UUID => 'not-a-uuid',
        ]);

        $uuid = $chunk->getUuid();
        $this->assertNotSame('not-a-uuid', $uuid, 'Invalid provided UUID must be replaced.');
        $this->assertTrue(Uuid::isValid($uuid), 'Replaced UUID should be valid.');
    }

    public function testGetSetTextAndMetadataValueFluent(): void
    {
        $chunk = new Chunk('initial');
        $this->assertSame('initial', $chunk->getText());

        $chunk->setText('updated');
        $this->assertSame('updated', $chunk->getText());

        // setMetadataValue should be fluent and readable via getMetadataValue.
        $ret = $chunk->setMetadataValue('foo', 'bar');
        $this->assertSame($chunk, $ret, 'setMetadataValue should be fluent.');
        $this->assertSame('bar', $chunk->getMetadataValue('foo'));
        $this->assertSame('default', $chunk->getMetadataValue('missing', 'default'));
    }

    public function testSetMetadataReplacesWholeArray(): void
    {
        $chunk = new Chunk('x', ['a' => 1, 'b' => 2]);

        $chunk->setMetadata(['c' => 3]);
        $meta = $chunk->getMetadata();

        $this->assertArrayHasKey('c', $meta);
        $this->assertSame(3, $meta['c']);
        $this->assertArrayNotHasKey('a', $meta, 'Old metadata should be replaced entirely.');
        $this->assertArrayNotHasKey('b', $meta);
    }

    public function testAddToMetadataInitializesArrayAndAppends(): void
    {
        $chunk = new Chunk('t');

        // First append should initialize an array
        $chunk->addToMetadata('tags', 'alpha');
        // Second append should push to array
        $chunk->addToMetadata('tags', 'beta');

        $this->assertSame(['alpha', 'beta'], $chunk->getMetadataValue('tags'));
    }

    public function testAddToMetadataThrowsWhenExistingIsNotArray(): void
    {
        $chunk = new Chunk('t');
        $chunk->setMetadataValue('tags', 'not-array');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('must be an array');
        $chunk->addToMetadata('tags', 'x');
    }

    public function testIndexAccessorsUseConstantKeyAndDefaultZero(): void
    {
        $chunk = new Chunk('t');
        // Default should be 0 if index is not set
        $this->assertSame(0, $chunk->getIndex());

        $ret = $chunk->setIndex(5);
        $this->assertSame($chunk, $ret, 'setIndex should be fluent.');
        $this->assertSame(5, $chunk->getIndex());
        $this->assertSame(5, $chunk->getMetadataValue(Chunk::METADATA_KEY_INDEX));
    }

    public function testSetUuidValidatesAndSets(): void
    {
        $chunk = new Chunk('t');
        $valid = Uuid::uuid7()->toString();

        $ret = $chunk->setUuid($valid);
        $this->assertSame($chunk, $ret, 'setUuid should be fluent.');
        $this->assertSame($valid, $chunk->getUuid());

        $this->expectException(InvalidArgumentException::class);
        $chunk->setUuid('invalid-uuid');
    }

    public function testGetChunkCollectionWrapsSingleChunkAndSetsIndex(): void
    {
        $chunk = new Chunk('hello world');

        $collection = $chunk->getChunkCollection();
        $this->assertInstanceOf(ChunkCollection::class, $collection);

        $chunks = $collection->getChunks();
        $this->assertCount(1, $chunks, 'Collection should contain a single chunk.');
        $this->assertSame('hello world', $collection->getContent(), 'Collection content should match chunk text.');

        // ChunkCollection constructor is expected to set the index on contained chunks.
        $this->assertSame(0, $chunks[0]->getIndex(), 'Wrapped single chunk should have index 0.');
        $this->assertSame($chunk->getUuid(), $chunks[0]->getUuid(), 'Same chunk instance should be preserved.');
    }

    public function testWordSplitUtility(): void
    {
        $text = 'a b c d e';
        $split2 = Chunk::wordSplit($text, 2);
        $this->assertSame(['a b', 'c d', 'e'], $split2);

        // Edge cases
        $this->assertSame([], Chunk::wordSplit('', 2), 'Empty string should yield empty array.');
        $this->assertSame([], Chunk::wordSplit("   \n\t  ", 2), 'Whitespace-only should yield empty array.');
        $this->assertSame([], Chunk::wordSplit('a b', 0), 'Non-positive wordsPerChunk should yield empty array.');
    }
}
