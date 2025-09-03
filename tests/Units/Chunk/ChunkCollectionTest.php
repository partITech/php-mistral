<?php

declare(strict_types=1);

namespace Tests\Units\Chunk;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Chunk\ChunkCollection;
use Partitech\PhpMistral\Interfaces\ChunkInterface;

/**
 * @covers \Partitech\PhpMistral\Chunk\ChunkCollection
 */
final class ChunkCollectionTest extends TestCase
{
    // ... keep other tests unchanged ...

    /**
     * Ensure strict (===) comparison is used when filtering by metadata.
     * We also assert the types before filtering to catch any unintended casting.
     */
    public function testFilterByMetadataUsesStrictComparison(): void
    {
        $c1 = $this->makeTestChunk('a', ['score' => 1]);     // int(1)
        $c2 = $this->makeTestChunk('b', ['score' => '1']);   // string("1")
        $c3 = $this->makeTestChunk('c', ['score' => 1.0]);   // float(1.0)

        $collection = new ChunkCollection([$c1, $c2, $c3]);

        // Precondition: assert the types are what we expect (helps diagnose casting issues)
        $this->assertSame('integer', gettype($collection->getChunks()[0]->getMetadataValue('score')));
        $this->assertSame('string', gettype($collection->getChunks()[1]->getMetadataValue('score')));
        $this->assertSame('double', gettype($collection->getChunks()[2]->getMetadataValue('score')));

        // Strict comparison means only exact type + value match.
        $onlyInt = $collection->filterByMetadata('score', 1);
        $this->assertCount(1, $onlyInt->getChunks(), 'Filtering by int(1) should only match the int(1) chunk.');
        $this->assertSame('a', $onlyInt->getChunks()[0]->getText());

        $onlyString = $collection->filterByMetadata('score', '1');
        $this->assertCount(1, $onlyString->getChunks(), 'Filtering by string("1") should only match the string("1") chunk.');
        $this->assertSame('b', $onlyString->getChunks()[0]->getText());

        $onlyFloat = $collection->filterByMetadata('score', 1.0);
        $this->assertCount(1, $onlyFloat->getChunks(), 'Filtering by float(1.0) should only match the float(1.0) chunk.');
        $this->assertSame('c', $onlyFloat->getChunks()[0]->getText());
    }

    /**
     * Local test double for ChunkInterface.
     * Stores text and metadata without casting to preserve value types.
     */
    private function makeTestChunk(string $text = '', array $metadata = []): ChunkInterface
    {
        return new class($text, $metadata) implements ChunkInterface {
            private string $text;
            private array $metadata;

            public function __construct(string $text, array $metadata)
            {
                $this->text = $text;
                $this->metadata = $metadata;
            }

            public function setMetadataValue(string $key, $value): static
            {
                $this->metadata[$key] = $value;
                return $this;
            }

            public function getMetadataValue(string $key, $default = null): mixed
            {
                return $this->metadata[$key] ?? $default;
            }

            public function addToMetadata(string $key, mixed $value): void
            {
                $this->metadata[$key] = $value;
            }

            public function getText(): string
            {
                return $this->text;
            }

            public function getChunkCollection(): ChunkCollection
            {
                return new ChunkCollection([$this], $this->text, ['from' => 'test-double']);
            }

            public function setUuid(string $uuid): static
            {
                $this->metadata['uuid'] = $uuid;
                return $this;
            }
        };
    }
}
