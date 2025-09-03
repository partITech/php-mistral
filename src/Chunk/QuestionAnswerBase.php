<?php

declare(strict_types=1);

namespace Partitech\PhpMistral\Chunk;

use Partitech\PhpMistral\Interfaces\QuestionAnswerInterface;

/**
 * Base value object holding a question/answer pair.
 */
class QuestionAnswerBase implements QuestionAnswerInterface, \JsonSerializable

{
    /**
     * The user's question. Nullable to reflect optional initialization.
     */
    private ?string $question = null;

    /**
     * The assistant's answer. Nullable to reflect optional initialization.
     */
    private ?string $answer = null;

    /**
     * Optional constructor for convenience when both values are known.
     *
     * @param string|null $question The initial question, or null if not set yet.
     * @param string|null $answer   The initial answer, or null if not set yet.
     */
    public function __construct(?string $question = null, ?string $answer = null)
    {
        // Use setters to centralize normalization logic.
        if ($question !== null) {
            $this->setQuestion($question);
        }

        if ($answer !== null) {
            $this->setAnswer($answer);
        }
    }

    /**
     * Get the answer text.
     *
     * @return string|null The answer or null if not set yet.
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * Set the answer text.
     * @param string $answer Non-null answer string.
     * @return static Fluent interface.
     */
    public function setAnswer(string $answer): static
    {
        $this->answer = trim($answer);

        return $this;
    }

    /**
     * Get the question text.
     *
     * @return string|null The question or null if not set yet.
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * Set the question text.
     * @param string $question Non-null question string.
     * @return static Fluent interface.
     */
    public function setQuestion(string $question): static
    {
        $this->question = trim($question);

        return $this;
    }

    /**
     * Control JSON encoding.
     *
     * @return array{question: string|null, answer: string|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }

}