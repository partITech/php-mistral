<?php

namespace Tests\Units\Chunk\Strategies;

use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Chunk\Strategies\RecursiveCharacterTextSplitter;

/**
 * @covers \Partitech\PhpMistral\Chunk\Strategies\RecursiveCharacterTextSplitter
 */
final class RecursiveCharacterTextSplitterTest extends TestCase
{
    public function testEmptyInputReturnsEmptyArray(): void
    {
        $splitter = new RecursiveCharacterTextSplitter();
        $this->assertSame([], $splitter->chunk(''));
        $this->assertSame([], $splitter->chunk("   \n\t  "));
    }

    public function testNoSeparatorFallbackToFixedSizeChunks(): void
    {
        // No separators -> should split by fixed size chunkSize
        $splitter = new RecursiveCharacterTextSplitter(chunkSize: 4, overlap: 0, separators: []);
        $text = 'abcdefghij';

        $chunks = $splitter->chunk($text);

        $this->assertSame(['abcd', 'efgh', 'ij'], $chunks);
    }

    public function testRecursiveSplitByParagraphsDotsAndSpaces(): void
    {
        // With a large chunk size, recursion stops early and we keep higher-level splits.
        // Expect trimming and removal of empty results at root level.
        $splitter = new RecursiveCharacterTextSplitter(chunkSize: 1000, overlap: 0);
        $text = "A sentence one. Second sentence.\n\nNew para start. End.";

        $chunks = $splitter->chunk($text);

        // After splitting and root-level cleanup, we should get clean sentence fragments
        $this->assertSame(
            ['A sentence one. Second sentence.', 'New para start. End.'],
            $chunks
        );

        $splitter = new RecursiveCharacterTextSplitter(chunkSize: 1000, overlap: 0);
        $text = "A sentence one. Second sentence.\nNew para start. End.";

        $chunks = $splitter->chunk($text);

        // After splitting and root-level cleanup, we should get clean sentence fragments
        $this->assertSame(
            ["A sentence one. Second sentence.\nNew para start. End."],
            $chunks
        );
    }

    public function testOverlapAppendedFromSubsequentChunks(): void
    {
        // Force fixed-size chunks to have predictable overlap
        $splitter = new RecursiveCharacterTextSplitter(chunkSize: 4, overlap: 3, separators: []);
        $text = 'abcdefghij';

        $chunks = $splitter->chunk($text);

        // Base chunks: ['abcd', 'efgh', 'ij']
        // Overlaps (3 chars):
        // - for 'abcd': next concatenation = 'efgh ij' -> first 3 chars = 'efg' -> 'abcd efg'
        // - for 'efgh': next concatenation = 'ij' -> 'efgh ij'
        // - for 'ij': no next chunk -> 'ij'
        $this->assertSame(['abcd efg', 'efgh ij', 'ij'], $chunks);
    }

    public function testLastChunkHasNoOverlap(): void
    {
        $splitter = new RecursiveCharacterTextSplitter(chunkSize: 3, overlap: 2, separators: []);
        $text = 'abcdef'; // -> ['abc', 'def']

        $chunks = $splitter->chunk($text);

        // For 'abc': overlap from 'def' = 'de' -> 'abc de'
        // For 'def': no next chunk -> unchanged
        $this->assertSame(['abc de', 'def'], $chunks);
    }

    public function testConstructorClampsValuesIndirectly(): void
    {
        // chunkSize clamped to 1, overlap becomes 0 (since must be < chunkSize)
        $splitter = new RecursiveCharacterTextSplitter(chunkSize: 0, overlap: 5, separators: []);
        $text = 'abcdef';

        $chunks = $splitter->chunk($text);

        // Splits by size=1: no overlap, exact characters
        $this->assertSame(['a', 'b', 'c', 'd', 'e', 'f'], $chunks);
    }

    public function testDeepRecursionFallsBackToWordsWhenSentenceTooLong(): void
    {
        // Default separators: ["\n\n", ".", " "]
        // A long sentence without paragraph breaks should be split into words if it exceeds chunkSize.
        $splitter = new RecursiveCharacterTextSplitter(chunkSize: 10, overlap: 0);
        $text = 'AlphaBetaGammaDeltaEpsilon. short words split test';

        $chunks = $splitter->chunk($text);

        // 'AlphaBetaGammaDeltaEpsilon' > 10, next separator exists -> split deeper by ' ' (words).
        // First part: 'AlphaBetaGammaDeltaEpsilon' (no spaces) -> still > 10 and no further separator at this branch?
        // Actually, after dot split, we get ['AlphaBetaGammaDeltaEpsilon', ' short words split test']
        // For the first piece (no spaces), it still exceeds chunkSize and there IS a next separator (' '),
        // but explode(' ', ...) yields ['AlphaBetaGammaDeltaEpsilon'] -> remains as is.
        // Root-level cleanup trims and removes empties:
        $this->assertContains('AlphaBetaGammaDeltaEpsilon', $chunks);
        $this->assertContains('short', $chunks);
        $this->assertContains('words', $chunks);
        $this->assertContains('split', $chunks);
        $this->assertContains('test', $chunks);
    }
}
