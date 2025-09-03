<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Exporter;

use ArrayObject;
use InvalidArgumentException;
use JsonException;
use Partitech\PhpMistral\Chunk\ChunkCollection;
use Partitech\PhpMistral\Interfaces\FormatExporterInterface;
use Partitech\PhpMistral\Messages;
use RuntimeException;

/**
 * Class ChunkExporter
 *
 * Purpose:
 * - Accepts either an ArrayObject of Messages objects or a ChunkCollection.
 * - Normalizes input into a flat ArrayObject<Messages>.
 * - Exports each Messages group using a provided FormatExporterInterface.
 * - Persists the JSON Lines (JSONL) output to a file when requested.
 *
 * Notes:
 * - Each line in the exported string is a JSON object corresponding to one Messages group.
 */
class ChunkExporter
{
    /**
     * @var ArrayObject<int, Messages> Collection of Messages objects to export.
     */
    private ArrayObject $messagesCollection;

    /**
     * @param ArrayObject|ChunkCollection $messagesCollection Collection of Messages objects
     *                                                       (or a ChunkCollection convertible to that).
     */
    public function __construct(ArrayObject|ChunkCollection $messagesCollection)
    {
        // Normalize input to an ArrayObject<Messages>.
        if ($messagesCollection instanceof ChunkCollection) {
            $messagesCollection = $this->convertChunkCollectionToMessagesCollection($messagesCollection);
        }

        $this->messagesCollection = $messagesCollection;
    }

    /**
     * Convert a ChunkCollection into a flat ArrayObject of Messages objects.
     *
     * @param ChunkCollection $chunkCollection
     * @return ArrayObject<int, Messages>
     *
     * @throws InvalidArgumentException If the chunks produce an invalid messages format.
     */
    private function convertChunkCollectionToMessagesCollection(ChunkCollection $chunkCollection): ArrayObject
    {
        // Will contain the final list of Messages objects.
        $messagesCollection = new ArrayObject();

        foreach ($chunkCollection->getChunks() as $chunk) {
            // Retrieve messages produced by each chunk.
            // Contract: toMessages() returns either an array or a Traversable of Messages.
            $messages = $chunk->toMessages();

            // Normalize Traversable to array for consistent iteration.
            if ($messages instanceof \Traversable) {
                $messages = iterator_to_array($messages);
            }

            if (!is_array($messages)) {
                throw new InvalidArgumentException('Invalid messages format, expected an array or Traversable.');
            }

            // Improvement: append items instead of re-creating ArrayObject on each iteration.
            // This avoids unnecessary array copies and object allocations.
            foreach ($messages as $msg) {
                if (!$msg instanceof Messages) {
                    throw new InvalidArgumentException('Each element must be an instance of Messages.');
                }
                $messagesCollection->append($msg);
            }
        }

        return $messagesCollection;
    }

    /**
     * Export a collection of messages using the specified format exporter.
     *
     * Each Messages group is transformed into an array by the exporter, then JSON-encoded.
     * The result is a JSON Lines payload with one JSON object per line.
     *
     * @param FormatExporterInterface $formatExporter
     * @return string JSON Lines string (one line per message group).
     *
     * @throws JsonException If JSON encoding fails.
     * @throws InvalidArgumentException If an element of the collection is not a Messages instance.
     */
    public function export(FormatExporterInterface $formatExporter): string
    {
        $lines = [];

        foreach ($this->messagesCollection as $index => $messages) {
            // Validate the element type to prevent runtime type errors downstream.
            if (!$messages instanceof Messages) {
                throw new InvalidArgumentException(sprintf(
                    'messagesCollection element at index %d is not an instance of %s.',
                    (int)$index,
                    Messages::class
                ));
            }

            // Delegate the structure conversion to the provided exporter.
            $data = $formatExporter->export($messages);

            // Use JSON_THROW_ON_ERROR for robust error handling.
            // JSON_UNESCAPED_UNICODE improves readability for non-ASCII content.
            $lines[] = json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        }

        // Join lines with a single newline (no trailing newline here; handled in save()).
        return implode("\n", $lines);
    }

    /**
     * Save a JSON Lines string to the provided file path.
     *
     * Behavior:
     * - Ensures the target directory exists (creates it if necessary).
     * - Appends to the file by default (atomic-ish write with LOCK_EX).
     * - Ensures the content ends with a newline (one record per line).
     *
     * @param string $jsonLines JSON Lines content to write.
     * @param string $filePath  Target file path.
     *
     * @throws RuntimeException If the directory creation or file write fails.
     */
    public function save(string $jsonLines, string $filePath): void
    {
        $directory = dirname($filePath);

        // Create the directory if it does not exist.
        // Improvement: prefer 0775 for shared environments; recursive creation enabled.
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created.', $directory));
        }

        // Ensure the payload ends with a newline so each JSON object occupies exactly one line.
        $payload = rtrim($jsonLines, "\r\n") . PHP_EOL;

        // Improvement: add LOCK_EX to reduce race conditions on concurrent writes.
        if (file_put_contents(filename: $filePath, data: $payload, flags: FILE_APPEND | LOCK_EX) === false) {
            throw new RuntimeException(sprintf('Failed to write to file: %s', $filePath));
        }
    }
}