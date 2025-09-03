<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Exporter\Formats;

use InvalidArgumentException;
use Partitech\PhpMistral\Interfaces\FormatExporterInterface;
use Partitech\PhpMistral\Messages;
use Ramsey\Uuid\Uuid;

/**
 * Exporter that transforms Messages into the "ragatouilleTrainer" format.
 *
 * Assumptions:
 * - The first message is the question.
 * - The second message is the answer.
 * - Metadata may contain a 'uuid' key; if missing, one is generated.
 *
 * Note:
 * - We validate that at least two messages exist to avoid runtime notices.
 * - We avoid relying on iterators' mutable state for clarity and robustness.
 */
final class RagatouilleTrainer implements FormatExporterInterface
{
    /**
     * Get the exporter name.
     *
     * @return string Non-localized identifier used as the "type" in the resulting payload.
     */
    public function getName(): string
    {
        return 'ragatouilleTrainer';
    }

    /**
     * Export the messages to the "ragatouilleTrainer" array structure.
     *
     * Expected output structure:
     * - question: string
     * - content: array{
     *     content: string,
     *     document_id: string
     *   }
     * - corpus: string
     * - uuid: string
     * - type: string
     * - metadata: array<string, mixed>
     *
     * @param Messages $messages Source messages collection.
     * @return array<string, mixed>
     *
     * @throws InvalidArgumentException When fewer than 2 messages are provided.
     */
    public function export(Messages $messages): array
    {
        // Validate we have at least 2 messages (question + answer).
        // Bad practice in original: relying on iterator current()/next() without checking size can cause notices.
        if ($messages->getMessages()->count() < 2) {
            throw new InvalidArgumentException('At least two messages (question and answer) are required for export.');
        }

        // Access the first two messages directly for clarity and safety.
        // Better than mutating an iterator's internal pointer.
        $questionMessage = $messages->first();
        $answerMessage   = $messages->offset(1);

        // Extra safety: ensure objects exist (should be true given the count check).
        if ($questionMessage === null || $answerMessage === null) {
            throw new InvalidArgumentException('Unable to resolve question/answer messages.');
        }

        // Extract plain string content. Trim to avoid trailing newlines/spaces.
        $question = trim((string) $questionMessage->getContent());
        $answer   = trim((string) $answerMessage->getContent());

        // Pull metadata; if a 'uuid' is not set, generate a stable one for document_id.
        $metadata = $messages->getMetadata();
        $documentId = isset($metadata['uuid']) && is_string($metadata['uuid']) && $metadata['uuid'] !== ''
            ? $metadata['uuid']
            : Uuid::uuid7()->toString(); // Improvement: avoid undefined index notice and ensure a valid UUID.

        // Build the payload.
        return [
            // The question (first message content).
            'question' => $question,

            // The answer is placed under "content.content"; "document_id" helps link to a source document.
            'content' => [
                'content'     => $answer,
                'document_id' => $documentId,
            ],

            // Additional context/corpus provided by Messages.
            'corpus' => $messages->getContext(),

            // Unique identifier for this exported entry.
            'uuid' => Uuid::uuid7()->toString(),

            // Exporter type identifier.
            'type' => $this->getName(),

            // Original metadata preserved.
            'metadata' => $metadata,
        ];
    }
}