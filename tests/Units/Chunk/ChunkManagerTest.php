<?php

namespace Tests\Units\Chunk;


use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Chunk\ChunkCollection;
use Partitech\PhpMistral\Chunk\ChunkManager;
use Partitech\PhpMistral\Interfaces\ChunkInterface;
use Partitech\PhpMistral\Interfaces\ChunkStrategyInterface;

/**
 * @covers \Partitech\PhpMistral\Chunk\ChunkManager
 */
final class ChunkManagerTest extends TestCase
{
    /**
     * Happy path: the manager delegates to the strategy and returns a ChunkCollection
     * containing the provided chunks and preserving the original text.
     */
    public function testCreateChunksReturnsCollectionWithOriginalContent(): void
    {
        $originalText = "Alpha\nBeta\nGamma";

        // Build a strategy stub that returns two valid Chunk instances.
        $chunks = [
            new Chunk('Alpha', ['foo' => 'bar']),
            new Chunk('Beta', ['baz' => 123]),
        ];
        $strategy = new class($chunks) implements ChunkStrategyInterface {
            public function __construct(private array $chunks) {}
            public function chunk(string $text): array { return $this->chunks; }
        };

        $manager = new ChunkManager($strategy);

        $collection = $manager->createChunks($originalText);

        $this->assertInstanceOf(ChunkCollection::class, $collection, 'Should wrap results into a ChunkCollection.');
        $this->assertSame($originalText, $collection->getContent(), 'Original text must be preserved on the collection.');

        $resultChunks = $collection->getChunks();
        $this->assertCount(2, $resultChunks);
        $this->assertInstanceOf(ChunkInterface::class, $resultChunks[0]);
        $this->assertInstanceOf(ChunkInterface::class, $resultChunks[1]);

        // Ensure the same instances are present (no unintended cloning).
        $this->assertSame($chunks[0], $resultChunks[0]);
        $this->assertSame($chunks[1], $resultChunks[1]);
    }

    /**
     * The manager must validate that all returned elements implement ChunkInterface.
     * If not, it should fail fast with an InvalidArgumentException.
     */
    public function testThrowsWhenStrategyReturnsNonChunkItems(): void
    {
        // Strategy returns an array that contains a non-Chunk element.
        $strategy = new class implements ChunkStrategyInterface {
            public function chunk(string $text): array
            {
                return [
                    new Chunk('valid'),
                    'not-a-chunk', // <- invalid element
                    new Chunk('also-valid'),
                ];
            }
        };

        $manager = new ChunkManager($strategy);

        $this->expectException(InvalidArgumentException::class);
        $manager->createChunks('some text');
    }

    /**
     * The manager should work with an empty result from the strategy,
     * producing a ChunkCollection with no chunks.
     */
    public function testEmptyArrayFromStrategyProducesEmptyCollection(): void
    {
        $strategy = new class implements ChunkStrategyInterface {
            public function chunk(string $text): array { return []; }
        };

        $manager = new ChunkManager($strategy);

        $collection = $manager->createChunks('anything');
        $this->assertInstanceOf(ChunkCollection::class, $collection);
        $this->assertSame('anything', $collection->getContent());
        $this->assertSame([], $collection->getChunks());
        $this->assertSame(0, $collection->count());
    }

    /**
     * Integration with ChunkCollection: verify that "index" metadata is normalized
     * to the chunk positions within the collection (0..N-1).
     *
     * Note: This tests the observable effect after the manager wraps the chunks,
     * not the internal implementation of ChunkCollection.
     */
    public function testChunkIndexMetadataIsNormalized(): void
    {
        $chunks = [
            new Chunk('first'),
            new Chunk('second'),
            new Chunk('third'),
        ];

        $strategy = new class($chunks) implements ChunkStrategyInterface {
            public function __construct(private array $chunks) {}
            public function chunk(string $text): array { return $this->chunks; }
        };

        $manager = new ChunkManager($strategy);
        $collection = $manager->createChunks('abc');

        $resultChunks = $collection->getChunks();
        $this->assertCount(3, $resultChunks);

        // Check "index" metadata is set as 0, 1, 2 respectively.
        foreach ($resultChunks as $i => $chunk) {
            $this->assertSame($i, $chunk->getMetadataValue('index'), "Chunk at position {$i} should have index={$i}.");
        }
    }

    /**
     * Ensure that large inputs are passed through without the manager altering the chunk content.
     * The manager should not modify chunks' text or metadata; that is the strategy's responsibility.
     */
    public function testManagerDoesNotAlterChunkContentOrMetadata(): void
    {
        $c1 = new Chunk('payload one', ['type' => 'custom', 'x' => 1]);
        $c2 = new Chunk('payload two', ['type' => 'custom', 'x' => 2]);

        $strategy = new class($c1, $c2) implements ChunkStrategyInterface {
            public function __construct(private Chunk $c1, private Chunk $c2) {}
            public function chunk(string $text): array { return [$this->c1, $this->c2]; }
        };

        $manager = new ChunkManager($strategy);
        $collection = $manager->createChunks('original text');

        $chunks = $collection->getChunks();

        // Same instances
        $this->assertSame($c1, $chunks[0]);
        $this->assertSame($c2, $chunks[1]);

        // Original metadata keys remain (index may be added/updated by the collection)
        $this->assertSame('custom', $chunks[0]->getMetadataValue('type'));
        $this->assertSame(1, $chunks[0]->getMetadataValue('x'));
        $this->assertSame('custom', $chunks[1]->getMetadataValue('type'));
        $this->assertSame(2, $chunks[1]->getMetadataValue('x'));
    }
}
