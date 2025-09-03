<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Exporter\Formats;

use InvalidArgumentException;
use Partitech\PhpMistral\Interfaces\FormatExporterInterface;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Message;

/**
 * Exporter for the Alpaca training format.
 *
 * Expected mapping:
 * - instruction: A general instruction or context for the conversation
 * - input:       The user's question/prompt
 * - output:      The assistant's answer
 *
 * Notes:
 * - This exporter assumes the first two conversation messages are:
 *   1) A user message (question)
 *   2) An assistant message (answer)
 * - If fewer than two messages exist, an exception is thrown.
 */
class AlpacaFormatExporter implements FormatExporterInterface
{
    /**
     * Get the unique name of this format.
     */
    public function getName(): string
    {
        return 'alpaca';
    }

    /**
     * Export the given Messages object into the Alpaca-compatible array.
     *
     * @param Messages $messages The conversation wrapper that contains messages and context.
     *
     * @return array{
     *     instruction: string,
     *     input: string|null,
     *     output: string|null
     * }
     */
    public function export(Messages $messages): array
    {
        // Retrieve the internal storage as an array copy to access by index.
        // This avoids manual iterator pointer handling (clearer and less error-prone).
        $list = $messages->getMessages()->getArrayCopy();

        // Ensure we have at least two messages (question + answer).
        if (count($list) < 2) {
            throw new InvalidArgumentException('Alpaca export requires at least two messages (user question and assistant answer).');
        }

        // Extract the first two messages.
        $first = $list[0] ?? null;
        $second = $list[1] ?? null;

        // Convert to Message instances if needed (Messages::format shows mixed input possible).
        $questionContent = $this->extractContent($first);
        $answerContent = $this->extractContent($second);

        // Optional role sanity-check (safer datasets).
        // If roles exist, we prefer user -> assistant ordering; we do not fail if roles are absent.
        $firstRole = $this->extractRole($first);
        $secondRole = $this->extractRole($second);

        // If roles are present and clearly mismatched, we still proceed but note: dataset quality matters.
        // You can uncomment the exception below to enforce strict role ordering.
        // if ($firstRole !== null && $firstRole !== Messages::ROLE_USER) {
        //     throw new InvalidArgumentException('First message should be a user message.');
        // }
        // if ($secondRole !== null && $secondRole !== Messages::ROLE_ASSISTANT) {
        //     throw new InvalidArgumentException('Second message should be an assistant message.');
        // }

        // Build the Alpaca-compatible structure.
        return [
            // Context/instruction for the pair; empty string if none was set.
            'instruction' => $messages->getContext(),
            // The user question/prompt (may be null if input message had no textual content).
            'input'       => $questionContent,
            // The assistant answer (may be null if answer was not textual).
            'output'      => $answerContent,
        ];
    }

    /**
     * Safely extract a textual content string from a message-like entity.
     *
     * Supports:
     * - Partitech\PhpMistral\Message objects
     * - array structures shaped like ['content' => string|array]
     * - Returns null if content is absent or not a string.
     *
     * @param mixed $message A Message instance or an array-like message
     * @return string|null
     */
    private function extractContent(mixed $message): ?string
    {
        // Message object case
        if ($message instanceof Message) {
            $content = $message->getContent();
            // Normalize potential array content to string if needed.
            return is_string($content) ? $content : (is_array($content) ? $this->flattenContentArray($content) : null);
        }

        // Array-like case
        if (is_array($message)) {
            $content = $message['content'] ?? null;
            return is_string($content) ? $content : (is_array($content) ? $this->flattenContentArray($content) : null);
        }

        // Unknown type
        return null;
    }

    /**
     * Extract the role from a message-like entity if available.
     *
     * @param mixed $message
     * @return string|null
     */
    private function extractRole(mixed $message): ?string
    {
        if ($message instanceof Message) {
            return $message->getRole();
        }
        if (is_array($message)) {
            return $message['role'] ?? null;
        }
        return null;
    }

    /**
     * Convert a mixed content array (e.g., OpenAI-style "content" with multiple parts)
     * into a simple string for export. Non-text parts are ignored.
     *
     * Example input:
     * [
     *   ['type' => 'text', 'text' => 'Hello'],
     *   ['type' => 'image_url', 'image_url' => ['url' => '...']]
     * ]
     *
     * @param array $contentParts
     * @return string|null
     */
    private function flattenContentArray(array $contentParts): ?string
    {
        // Collect text segments only; ignore images or other non-text segments.
        $texts = [];
        foreach ($contentParts as $part) {
            if (is_array($part) && ($part['type'] ?? null) === 'text' && isset($part['text']) && is_string($part['text'])) {
                $texts[] = $part['text'];
            }
        }

        // Join text segments into a single string or return null if none.
        return $texts !== [] ? implode("\n", $texts) : null;
    }
}