<?php

namespace Tests\Units\Chunk;

use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Chunk\QuestionAnswerBase;
use Partitech\PhpMistral\Interfaces\QuestionAnswerInterface;

/**
 * @covers \Partitech\PhpMistral\Chunk\QuestionAnswerBase
 */
final class QuestionAnswerBaseTest extends TestCase
{
    public function testDefaultStateIsNull(): void
    {
        // By default, no values are set; getters should return null.
        $qna = new QuestionAnswerBase();

        $this->assertNull($qna->getQuestion(), 'Question should be null by default.');
        $this->assertNull($qna->getAnswer(), 'Answer should be null by default.');
    }

    public function testImplementsInterface(): void
    {
        $qna = new QuestionAnswerBase();

        // Ensure it implements the expected contract.
        $this->assertInstanceOf(QuestionAnswerInterface::class, $qna);
    }

    public function testConstructorSetsValuesAndTrims(): void
    {
        // Constructor should set fields and apply trimming through setters.
        $qna = new QuestionAnswerBase("  What is PHP?  ", "\tA language.\n");

        $this->assertSame('What is PHP?', $qna->getQuestion());
        $this->assertSame('A language.', $qna->getAnswer());
    }

    public function testSettersTrimAndAreFluent(): void
    {
        $qna = new QuestionAnswerBase();

        // Fluent interface: setters should return the same instance (static).
        $ret1 = $qna->setQuestion("  Hello world  ");
        $ret2 = $qna->setAnswer("\nAnswer here\t");

        $this->assertSame($qna, $ret1, 'setQuestion should return the same instance for chaining.');
        $this->assertSame($qna, $ret2, 'setAnswer should return the same instance for chaining.');

        // Trimming should remove leading/trailing whitespace.
        $this->assertSame('Hello world', $qna->getQuestion());
        $this->assertSame('Answer here', $qna->getAnswer());
    }

    public function testSettingWhitespaceOnlyResultsInEmptyString(): void
    {
        $qna = new QuestionAnswerBase();

        // Whitespace-only input becomes an empty string after trim (still a valid string).
        $qna->setQuestion("   \t  ");
        $qna->setAnswer("\n   ");

        $this->assertSame('', $qna->getQuestion());
        $this->assertSame('', $qna->getAnswer());
    }

    public function testChainingMultipleSetters(): void
    {
        $qna = new QuestionAnswerBase();

        // Chaining should be possible and preserve the last values set.
        $qna
            ->setQuestion('First?')
            ->setAnswer('First!')
            ->setQuestion('Second?')
            ->setAnswer('Second!');

        $this->assertSame('Second?', $qna->getQuestion());
        $this->assertSame('Second!', $qna->getAnswer());
    }
}
