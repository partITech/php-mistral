<?php

declare(strict_types=1);

namespace Partitech\PhpMistral\Chunk;

use InvalidArgumentException;
use Partitech\PhpMistral\Interfaces\ChunkInterface;
use Ramsey\Uuid\Uuid;

/**
 * Represents a text chunk with associated metadata.
 *
 * Responsibilities:
 * - Hold a text fragment and arbitrary metadata.
 * - Ensure each chunk has a valid UUID in its metadata.
 * - Provide helpers to access/modify metadata and to wrap itself
 *   into a ChunkCollection.
 */
class Chunk implements ChunkInterface
{
    use ChunkTrait;

    /** @var string Metadata key used to store Q/A pairs (consumed by ChunkTrait::toMessages). */
    public const METADATA_KEY_QNA = 'qna';

    /** @var string Metadata key used to store the index of the chunk within a collection. */
    public const METADATA_KEY_INDEX = 'index';

    /** @var string Metadata key used to store the UUID of the chunk. */
    public const METADATA_KEY_UUID = 'uuid';

    /**
     * The text content of the chunk.
     * Note: kept non-null to respect getText(): string from the interface.
     */
    private string $text;

    /**
     * Arbitrary metadata associated with this chunk.
     * Typical entries:
     * - self::METADATA_KEY_UUID => string
     * - self::METADATA_KEY_INDEX => int
     * - self::METADATA_KEY_QNA => list<QuestionAnswerInterface>
     *
     * @var array<string, mixed>
     */
    private array $metadata;

    /**
     * @param string|null $text     The text of the chunk. If null, it is normalized to empty string.
     * @param array<string, mixed> $metadata Arbitrary metadata; a UUID will be injected if absent/invalid.
     */
    public function __construct(?string $text = null, array $metadata = [])
    {
        // Normalize null to empty string to fulfill getText(): string.
        $this->text = $text ?? '';

        // Ensure we have a valid UUID in metadata; generate one if absent/invalid.
        if (
            !isset($metadata[self::METADATA_KEY_UUID]) ||
            !is_string($metadata[self::METADATA_KEY_UUID]) ||
            !Uuid::isValid($metadata[self::METADATA_KEY_UUID])
        ) {
            $metadata[self::METADATA_KEY_UUID] = Uuid::uuid7()->toString();
        }

        $this->metadata = $metadata;
    }

    /**
     * Get the chunk text (never null).
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Set/replace the chunk text.
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Get the entire metadata array.
     *
     * @return array<string, mixed>
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Replace the entire metadata array.
     *
     * Note: This does not re-validate or regenerate the UUID. If you need to
     * ensure a valid UUID after replacing, call setUuid() explicitly.
     *
     * @param array<string, mixed> $metadata
     */
    public function setMetadata(array $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * Get a single metadata value by key with a default.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getMetadataValue(string $key, $default = null): mixed
    {
        return $this->metadata[$key] ?? $default;
    }

    /**
     * Set a single metadata value (fluent).
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function setMetadataValue(string $key, $value): static
    {
        $this->metadata[$key] = $value;

        return $this;
    }

    /**
     * Add a value to a metadata array entry, initializing it as an array if absent.
     * Throws if the existing entry is not an array.
     *
     * @param string $key
     * @param mixed $value
     */
    public function addToMetadata(string $key, mixed $value): void
    {
        if (!isset($this->metadata[$key])) {
            $this->metadata[$key] = [];
        }

        if (!is_array($this->metadata[$key])) {
            // Improvement: use a local imported exception class and a clear message.
            throw new InvalidArgumentException(sprintf('The value at metadata[%s] must be an array.', $key));
        }

        $this->metadata[$key][] = $value;
    }

    /**
     * Convenience accessor for the index in a collection.
     * Returns 0 by default when not set (cast to int to respect the declared return type).
     */
    public function getIndex(): int
    {
        return (int) $this->getMetadataValue(self::METADATA_KEY_INDEX, 0);
    }

    /**
     * Set the index in a collection (fluent).
     */
    public function setIndex(int $index): self
    {
        $this->setMetadataValue(self::METADATA_KEY_INDEX, $index);

        return $this;
    }

    /**
     * Get the chunk UUID from metadata.
     */
    public function getUuid(): string
    {
        /** @var string $uuid */
        $uuid = $this->getMetadataValue(self::METADATA_KEY_UUID, '');
        return $uuid;
    }

    /**
     * Set/override the UUID in metadata (fluent).
     * Validates the given UUID; if invalid, throws an InvalidArgumentException.
     */
    public function setUuid(string $uuid): static
    {
        // Defensive validation; matches what constructor enforces.
        if (!Uuid::isValid($uuid)) {
            throw new InvalidArgumentException('Provided UUID is not valid.');
        }

        return $this->setMetadataValue(self::METADATA_KEY_UUID, $uuid);
    }

    /**
     * Wrap this single chunk into a ChunkCollection.
     * The collection receives this chunk as its sole element and the current text as content.
     */
    public function getChunkCollection(): ChunkCollection
    {
        return new ChunkCollection([$this], $this->getText());
    }

    /**
     * Split a string into chunks containing a specific number of words.
     *
     * @param string $string        The input string.
     * @param int    $wordsPerChunk Number of words per chunk (must be >= 1).
     * @return array<int, string>   An array of chunk strings.
     */
    public static function wordSplit(string $string, int $wordsPerChunk): array
    {
        // Normalize and guard against empty input.
        $normalized = trim($string);
        if ($normalized === '' || $wordsPerChunk < 1) {
            return [];
        }

        // Split on any run of whitespace to be robust (spaces, tabs, newlines).
        $words = preg_split('/\s+/', $normalized);
        if (!is_array($words) || $words === []) {
            return [];
        }

        // Group words into fixed-size arrays, then join back with single spaces.
        $chunks = array_chunk($words, $wordsPerChunk);

        return array_map(
            static fn(array $chunk): string => implode(' ', $chunk),
            $chunks
        );
    }
}