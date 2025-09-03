<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Exporter\Formats;

use InvalidArgumentException;
use Partitech\PhpMistral\Interfaces\FormatExporterInterface;
use Partitech\PhpMistral\Messages;

/**
 * Exporter for Sentence Transformer training format.
 *
 * Responsibility:
 * - Extract the first "user" message as the question.
 * - Extract the first "assistant" message as the context/answer.
 * - Return a normalized payload: ['question' => string, 'context' => string].
 *
 * Note on input:
 * - Messages collection can contain either Message instances or array-shaped messages.
 * - We normalize both cases and ignore system/tool messages.
 */
class SentenceTransformerTrainerExporter implements FormatExporterInterface
{
    /**
     * Get the unique exporter name.
     */
    public function getName(): string
    {
        return 'sentenceTransformer';
    }

    /**
     * Export the messages into a Sentence Transformer-friendly array.
     *
     * Contract:
     * - Takes the first user message as "question".
     * - Takes the first assistant message (that appears after collection start) as "context".
     *
     * @param Messages $messages
     * @return array{question: string, context: string}
     *
     * @throws InvalidArgumentException When the required user/assistant messages are missing
     *                                  or when content cannot be normalized to string.
     */
    public function export(Messages $messages): array
    {
        // Iterate through the messages and grab the first user and assistant contents.
        $question = null;
        $answer   = null;

        foreach ($messages->getMessages() as $item) {
            // Extract normalized role/content from either an object or an array.
            $role    = $this->extractRole($item);
            $content = $this->extractContentAsString($item);

            // Skip messages without a role/content we can use.
            if ($role === null || $content === null || $content === '') {
                continue;
            }

            // First user message becomes the question.
            if ($question === null && $role === Messages::ROLE_USER) {
                $question = $content;
                continue;
            }

            // First assistant message becomes the context/answer.
            if ($answer === null && $role === Messages::ROLE_ASSISTANT) {
                $answer = $content;
            }

            // Early exit when both are found.
            if ($question !== null && $answer !== null) {
                break;
            }
        }

        // Validate extracted data.
        if ($question === null || $question === '') {
            throw new InvalidArgumentException('Unable to export: no user message found for "question".');
        }
        if ($answer === null || $answer === '') {
            throw new InvalidArgumentException('Unable to export: no assistant message found for "context".');
        }

        return [
            'question' => $question,
            'context'  => $answer,
        ];
    }

    /**
     * Extract the role from a message entry which can be an object or an array.
     *
     * @param mixed $item
     * @return string|null Returns one of Messages::ROLE_* or null if not available.
     */
    private function extractRole(mixed $item): ?string
    {
        // Object case: use getRole()/role() if available.
        if (is_object($item)) {
            if (method_exists($item, 'getRole')) {
                /** @var mixed $role */
                $role = $item->getRole();
                return is_string($role) ? $role : null;
            }
            if (method_exists($item, 'role')) {
                /** @var mixed $role */
                $role = $item->role();
                return is_string($role) ? $role : null;
            }
            return null;
        }

        // Array case: rely on 'role' key when present.
        if (is_array($item) && isset($item['role']) && is_string($item['role'])) {
            return $item['role'];
        }

        return null;
    }

    /**
     * Extract the content as a string from a message entry which can be an object or an array.
     *
     * Behavior:
     * - For object messages, prefers getContent().
     * - For array messages, prefers 'content' key.
     * - If content is array (mixed content), safely JSON-encode it.
     * - Trims the result to avoid leading/trailing whitespace.
     *
     * @param mixed $item
     * @return string|null
     */
    private function extractContentAsString(mixed $item): ?string
    {
        $content = null;

        // Object case
        if (is_object($item) && method_exists($item, 'getContent')) {
            $content = $item->getContent();
        }

        // Array case
        if ($content === null && is_array($item) && array_key_exists('content', $item)) {
            $content = $item['content'];
        }

        if ($content === null) {
            return null;
        }

        // Normalize to string:
        // - If already string, trim it.
        // - If array, JSON-encode to preserve structure (common for mixed content).
        // - Otherwise, cast to string as a last resort.
        if (is_string($content)) {
            return trim($content);
        }

        if (is_array($content)) {
            // Good practice: JSON_UNESCAPED_UNICODE improves readability for non-ASCII content.
            $encoded = json_encode($content, JSON_UNESCAPED_UNICODE);
            return $encoded !== false ? trim($encoded) : null;
        }

        // Fallback: cast scalar/object to string.
        $stringified = (string) $content;
        return $stringified !== '' ? trim($stringified) : null;
    }
}