<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Chunk;

use InvalidArgumentException;
use Partitech\PhpMistral\Interfaces\ChunkInterface;

/**
 * Collection of chunks produced by a text splitter or similar process.
 *
 * Responsibilities:
 * - Store the raw content that was chunked (optional).
 * - Hold an ordered list of chunks with per-chunk metadata.
 * - Provide basic utilities to retrieve and filter chunks.
 *
 * @phpstan-type ChunkList array<int, ChunkInterface>
 *
 * @psalm-type ChunkList = array<int, ChunkInterface>
 */
class ChunkCollection
{
    /**
     * Optional original content that produced the chunks.
     *
     * @var string
     */
    private string $content;

    /**
     * Ordered list of chunks.
     *
     * @var ChunkList
     */
    private array $chunks;

    /**
     * Arbitrary collection-level metadata.
     *
     * @var array<string, mixed>
     */
    private array $metadata;

    /**
     * @param ChunkList            $chunks   List of chunks; their "index" metadata will be normalized.
     * @param string               $content  Original content (optional).
     * @param array<string, mixed> $metadata Collection-level metadata.
     *
     * @throws InvalidArgumentException If any element of $chunks is not a ChunkInterface.
     */
    public function __construct(array $chunks = [], string $content = '', array $metadata = [])
    {
        $this->content = $content;

        // Validate input and normalize indexing:
        $chunks = array_values($chunks);

        foreach ($chunks as $i => $chunk) {
            if (!$chunk instanceof ChunkInterface) {
                throw new InvalidArgumentException('All elements of $chunks must implement ChunkInterface.');
            }

            // Ensure each chunk knows its position within the collection.
            $chunk->setMetadataValue('index', $i);
        }

        $this->chunks = $chunks;
        $this->metadata = $metadata;
    }

    /**
     * Append a chunk to the collection.
     */
    public function addChunk(ChunkInterface $chunk): void
    {
        $chunk->setMetadataValue('index', count($this->chunks));
        $this->chunks[] = $chunk;
    }

    /**
     * Get all chunks in order.
     *
     * @return ChunkList
     */
    public function getChunks(): array
    {
        return $this->chunks;
    }

    /**
     * Get the original content the chunks were derived from (if provided).
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the original content.
     *
     * Fluent interface: returns $this to allow chaining.
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Return a new collection containing only the chunks that match a metadata key/value pair.
     *
     * @param string $key   Metadata key to filter by.
     * @param mixed  $value Metadata value to strictly compare (===) against.
     */
    public function filterByMetadata(string $key, mixed $value): self
    {
        $filteredChunks = array_filter(
            $this->chunks,
            static function (ChunkInterface $chunk) use ($key, $value): bool {
                return $chunk->getMetadataValue($key) === $value;
            }
        );

        // Re-index to ensure contiguous numeric keys and correct "index" metadata in the new collection.
        $filteredChunks = array_values($filteredChunks);

        // Preserve content and metadata of the original collection.
        return new self($filteredChunks, $this->content, $this->metadata);
    }

    /**
     * Get the first chunk in the collection or null if empty.
     */
    public function first(): ?ChunkInterface
    {
        return $this->chunks[0] ?? null;
    }

    /**
     * Count the number of chunks in the collection.
     */
    public function count(): int
    {
        return count($this->chunks);
    }

    /**
     * Get collection-level metadata.
     *
     * @return array<string, mixed>
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Set collection-level metadata.
     *
     * Fluent interface: returns $this to allow chaining.
     *
     * @param array<string, mixed> $metadata
     */
    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }
}