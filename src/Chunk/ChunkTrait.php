<?php

declare(strict_types=1);

namespace Partitech\PhpMistral\Chunk;

use ArrayObject;
use Traversable;
use Partitech\PhpMistral\Interfaces\QuestionAnswerInterface;
use Partitech\PhpMistral\Messages;

/**
 * Trait providing helpers to build Messages collections from chunk metadata.
 *
 * This trait expects the consuming class to expose metadata and text accessors.
 *
 * @method array getMetadata() Retrieve the entire metadata array of the chunk.
 * @method string getText() Retrieve the chunk's text/content used as context.
 * @method mixed getMetadataValue(string $key, $default = null) Get a single metadata value.
 * @method static setMetadataValue(string $key, $value): static Set a single metadata value.
 *
 * @phpstan-type QnaItem QuestionAnswerInterface
 * @phpstan-type QnaList list<QnaItem>
 */
trait ChunkTrait
{
    /**
     * Build a list of Messages objects out of Q&A metadata.
     *
     * The method looks up METADATA_KEY_QNA and supports a variety of containers:
     * - ArrayObject
     * - An object exposing toArray()
     * - Traversable
     * - array
     *
     * It skips entries that do not implement QuestionAnswerInterface and ignores
     * empty/null question/answer pairs to avoid producing empty conversation turns.
     *
     * @return ArrayObject A list of Messages instances, one per Q&A pair.
     *
     * @phpstan-return ArrayObject<int, Messages>
     */
    public function toMessages(): ArrayObject
    {
        $result = new ArrayObject();

        // Retrieve the Q&A collection from metadata.
        // If not present or invalid, normalize to an empty array.
        $qna = $this->getMetadataValue(Chunk::METADATA_KEY_QNA);

        // Normalize various container types to a simple array.
        if ($qna instanceof ArrayObject) {
            $qna = $qna->getArrayCopy();
        } elseif (is_object($qna) && method_exists($qna, 'toArray')) {
            // Support Doctrine\Common\Collections\Collection and similar objects
            $qna = $qna->toArray();
        } elseif ($qna instanceof Traversable) {
            $qna = iterator_to_array($qna);
        } elseif (!is_array($qna)) {
            $qna = [];
        }

        // Early return if nothing to process.
        if (empty($qna)) {
            return $result;
        }

        // Iterate over Q&A items and build Messages objects.
        foreach ($qna as $qnaItem) {
            // Defensive check: only process items implementing the expected interface.
            // Improvement over original: previously assumed all items are valid.
            if (!$qnaItem instanceof QuestionAnswerInterface) {
                // We now skip invalid entries.
                continue;
            }

            // Fetch question/answer and ignore empty pairs to avoid no-op messages.
            $question = $qnaItem->getQuestion();
            $answer   = $qnaItem->getAnswer();

            // If both question and answer are null/empty, skip this entry.
            if ((null === $question || trim($question) === '') && (null === $answer || trim($answer) === '')) {
                continue;
            }

            $messages = new Messages();
            // Propagate chunk metadata and context to the Messages object.
            $messages->setMetadata($this->getMetadata());
            $messages->setContext($this->getText());

            // Add user/assistant turns only when present.
            if ($question !== null && trim($question) !== '') {
                $messages->addUserMessage($question);
            }

            if ($answer !== null && trim($answer) !== '') {
                $messages->addAssistantMessage($answer);
            }

            $result->append($messages);
        }

        return $result;
    }

    /**
     * Store the UUID in chunk metadata.
     *
     * Note: This does not validate the UUID format here. If validation is required,
     * it should be done by the caller or within setMetadataValue().
     *
     * @param string $uuid A UUID string (e.g., UUIDv7).
     * @return static Fluent interface.
     */
    public function setUuid(string $uuid): static
    {
        $this->setMetadataValue(Chunk::METADATA_KEY_UUID, $uuid);

        return $this;
    }
}