<?php

namespace Tests\Units\Chunk;

use ArrayIterator;
use ArrayObject;
use IteratorAggregate;
use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Chunk\QuestionAnswerBase;
use Partitech\PhpMistral\Interfaces\QuestionAnswerInterface;
use Partitech\PhpMistral\Messages;

/**
 * @covers \Partitech\PhpMistral\Chunk\ChunkTrait
 */
final class ChunkTraitTest extends TestCase
{
    /**
     * Ensures that:
     * - Each valid Q/A pair yields one Messages object.
     * - Messages contains user then assistant messages in order.
     * - Context and metadata are propagated.
     */
    public function testToMessagesWithArrayOfQna(): void
    {
        // Prepare a chunk with context and two Q/A pairs.
        $text = 'CTX';
        $qna = [
            new QuestionAnswerBase('Q1', 'A1'),
            new QuestionAnswerBase('Q2', 'A2'),
        ];

        $chunk = new Chunk($text, [
            Chunk::METADATA_KEY_QNA => $qna,
            'foo' => 'bar', // some extra metadata to validate propagation
        ]);

        $result = $chunk->toMessages();

        // One Messages per Q/A item
        $this->assertInstanceOf(ArrayObject::class, $result);
        $this->assertCount(2, $result);

        // Assert content and propagation for first Messages
        /** @var Messages $m1 */
        $m1 = $result[0];
        $this->assertInstanceOf(Messages::class, $m1);

        // format() should return a plain array of normalized messages
        $formatted1 = $m1->format();
        $this->assertIsArray($formatted1);
        $this->assertSame('user', $formatted1[0]['role']);
        $this->assertSame('Q1', $formatted1[0]['content']);
        $this->assertSame('assistant', $formatted1[1]['role']);
        $this->assertSame('A1', $formatted1[1]['content']);

        // Context and metadata propagation
        $this->assertSame($text, $m1->getContext());
        $this->assertArrayHasKey('foo', $m1->getMetadata());
        $this->assertSame('bar', $m1->getMetadata()['foo']);

        // Second Messages checks
        /** @var Messages $m2 */
        $m2 = $result[1];
        $formatted2 = $m2->format();
        $this->assertSame('user', $formatted2[0]['role']);
        $this->assertSame('Q2', $formatted2[0]['content']);
        $this->assertSame('assistant', $formatted2[1]['role']);
        $this->assertSame('A2', $formatted2[1]['content']);
    }

    /**
     * Ensures that:
     * - Non-QuestionAnswerInterface entries are skipped.
     * - Entries with both question and answer empty/null are skipped.
     * - Question-only and answer-only entries produce a Messages with a single turn.
     */
    public function testToMessagesSkipsInvalidAndEmptyPairs(): void
    {
        // Build mixed inputs: invalid entry, empty Q/A, question-only, answer-only
        $invalid = 'not-an-interface';
        $emptyPair = new class() implements QuestionAnswerInterface {
            public function getAnswer(): ?string { return null; }
            public function setAnswer(string $answer): static { return $this; }
            public function getQuestion(): ?string { return null; }
            public function setQuestion(string $question): static { return $this; }
        };
        $questionOnly = new QuestionAnswerBase('I have a question', null);
        $answerOnly = new QuestionAnswerBase(null, 'Here is an answer');

        $chunk = new Chunk('CTX', [
            Chunk::METADATA_KEY_QNA => [$invalid, $emptyPair, $questionOnly, $answerOnly],
        ]);

        $result = $chunk->toMessages();

        // Expect only 2 Messages: one from question-only, one from answer-only
        $this->assertCount(2, $result);

        /** @var Messages $m1 */
        $m1 = $result[0];
        $formatted1 = $m1->format();
        $this->assertCount(1, $formatted1, 'Question-only should yield a single user message.');
        $this->assertSame('user', $formatted1[0]['role']);
        $this->assertSame('I have a question', $formatted1[0]['content']);

        /** @var Messages $m2 */
        $m2 = $result[1];
        $formatted2 = $m2->format();
        $this->assertCount(1, $formatted2, 'Answer-only should yield a single assistant message.');
        $this->assertSame('assistant', $formatted2[0]['role']);
        $this->assertSame('Here is an answer', $formatted2[0]['content']);
    }

    /**
     * Ensures that the QnA container can be:
     * - ArrayObject
     * - Object exposing toArray()
     * - Traversable
     */
    public function testToMessagesSupportsArrayObjectToArrayAndTraversable(): void
    {
        $qa1 = new QuestionAnswerBase('Q1', 'A1');
        $qa2 = new QuestionAnswerBase('Q2', 'A2');

        // Case 1: ArrayObject
        $chunkArrayObject = new Chunk('CTX1', [
            Chunk::METADATA_KEY_QNA => new ArrayObject([$qa1, $qa2]),
        ]);
        $res1 = $chunkArrayObject->toMessages();
        $this->assertCount(2, $res1);

        // Case 2: toArray() provider
        $toArrayProvider = new class([$qa1, $qa2]) {
            /** @var array<int, QuestionAnswerInterface> */
            private array $items;
            public function __construct(array $items) { $this->items = $items; }
            /** @return array<int, QuestionAnswerInterface> */
            public function toArray(): array { return $this->items; }
        };
        $chunkToArray = new Chunk('CTX2', [
            Chunk::METADATA_KEY_QNA => $toArrayProvider,
        ]);
        $res2 = $chunkToArray->toMessages();
        $this->assertCount(2, $res2);

        // Case 3: Traversable/IteratorAggregate
        $iterProvider = new class([$qa1, $qa2]) implements IteratorAggregate {
            /** @var array<int, QuestionAnswerInterface> */
            private array $items;
            public function __construct(array $items) { $this->items = $items; }
            public function getIterator(): \Traversable { return new ArrayIterator($this->items); }
        };
        $chunkTraversable = new Chunk('CTX3', [
            Chunk::METADATA_KEY_QNA => $iterProvider,
        ]);
        $res3 = $chunkTraversable->toMessages();
        $this->assertCount(2, $res3);
    }

    /**
     * Ensures that setUuid stores the given UUID into the metadata.
     * Note: This test does not validate UUID format; it only checks storage.
     */
    public function testSetUuidStoresInMetadata(): void
    {
        $chunk = new Chunk('CTX', []);
        $uuid = '00000000-0000-0000-0000-000000000000';

        // setUuid should store under METADATA_KEY_UUID
        $chunk->setUuid($uuid);

        $this->assertSame($uuid, $chunk->getMetadataValue(Chunk::METADATA_KEY_UUID));
    }
}
