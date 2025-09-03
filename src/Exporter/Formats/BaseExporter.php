<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Exporter\Formats;

use Partitech\PhpMistral\Interfaces\FormatExporterInterface;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

/**
 * BaseExporter
 *
 * Purpose:
 * - Provide a generic export format for a conversation into a simple array structure:
 *   [
 *     'messages' => [
 *       ['role' => '...', 'content' => '...'],
 *       ...
 *     ]
 *   ]
 *
 * Notes:
 * - This base implementation tries to be tolerant: it supports both Message objects
 *   and array-like messages (['role' => ..., 'content' => ...]).
 * - Child exporters can override field names by changing the protected properties.
 */
class BaseExporter implements FormatExporterInterface
{
    public const NAME = 'base';

    /**
     * The key used for the messages list in the exported payload.
     * Children can override this to adapt to specific formats.
     */
    protected string $fieldMessages = 'messages';

    /**
     * The key used for the role field in each message.
     */
    protected string $messageFieldRole = 'role';

    /**
     * The key used for the content field in each message.
     */
    protected string $messageFieldContent = 'content';

    /**
     * Export the conversation messages into a normalized, array-based structure.
     *
     * @param Messages $messages The conversation wrapper with its internal collection.
     * @return array{
     *     messages?: array<int, array{role?: string|null, content?: mixed}>
     * }
     */
    public function export(Messages $messages): array
    {
        // Retrieve a stable array copy for iteration and mapping.
        $list = $messages->getMessages()->getArrayCopy();

        // Map each message-like item to the target shape using safe extractors.
        $normalized = array_map(
            /**
             * @param Message|array $msg
             * @return array{role: string|null, content: mixed}
             */
            function (Message|array $msg): array {
                // Bad practice before: direct method calls on assumed Message instances.
                // Improvement: we tolerate array-like items to prevent runtime errors.
                return [
                    $this->messageFieldRole    => $this->extractRole($msg),
                    $this->messageFieldContent => $this->extractContent($msg),
                ];
            },
            $list
        );

        return [
            $this->fieldMessages => $normalized,
        ];
    }

    /**
     * Get the unique exporter name.
     *
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Extract the role from a message-like entity.
     * Supports:
     * - Message objects
     * - array-like messages with ['role' => string]
     *
     * @param Message|array $message
     * @return string|null
     */
    private function extractRole(Message|array $message): ?string
    {
        if ($message instanceof Message) {
            return $message->getRole();
        }

        return $message['role'] ?? null;
    }

    /**
     * Extract the content from a message-like entity.
     * Supports:
     * - Message objects
     * - array-like messages with ['content' => mixed]
     *
     * Note:
     * - We keep the content type as-is (string|array|mixed) to preserve original data.
     *   Child exporters can transform it if needed.
     *
     * @param Message|array $message
     * @return mixed
     */
    private function extractContent(Message|array $message): mixed
    {
        if ($message instanceof Message) {
            return $message->getContent();
        }

        return $message['content'] ?? null;
    }
}