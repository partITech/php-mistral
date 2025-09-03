<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Exporter\Formats;

/**
 * MistralFormatExporter
 *
 * Purpose:
 * - Provide the format identifier for "mistral" and (optionally) override
 *   message field names if the Mistral API expects specific keys.
 *
 * Usage:
 * - This class inherits the export() behavior from BaseExporter, which produces:
 *     [
 *       'messages' => [
 *         ['role' => '...', 'content' => '...'],
 *         ...
 *       ]
 *     ]
 * - If the Mistral API requires different keys, update $fieldMessages, $messageFieldRole,
 *   and $messageFieldContent accordingly.
 */
class MistralFormatExporter extends BaseExporter
{
    /**
     * Unique exporter name for the Mistral format.
     */
    public const NAME = 'mistral';

    /**
     * The key used for the messages list in the exported payload.
     * Keeping this explicit makes future format changes easier to track.
     */
    protected string $fieldMessages = 'messages';

    /**
     * The key used for the role field in each message.
     * Mirrors BaseExporter's default to remain explicit for this format.
     */
    protected string $messageFieldRole = 'role';

    /**
     * The key used for the content field in each message.
     * Mirrors BaseExporter's default to remain explicit for this format.
     */
    protected string $messageFieldContent = 'content';

    /**
     * Get the unique exporter name for this format.
     *
     * @return string The string identifier of this exporter ("mistral").
     */
    public function getName(): string
    {
        return self::NAME;
    }
}