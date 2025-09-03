<?php

namespace Tests\Units\Chunk\Strategies;

use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Chunk\Strategies\MarkdownSplitter;

/**
 * @covers \Partitech\PhpMistral\Chunk\Strategies\MarkdownSplitter
 */
final class MarkdownSplitterTest extends TestCase
{
    public function testEmptyInputReturnsEmptyArray(): void
    {
        $splitter = new MarkdownSplitter(chunkSize: 10);

        $chunks = $splitter->chunk('');
        $this->assertSame([], $chunks, 'Empty input should yield no chunks.');

        $chunks = $splitter->chunk("   \n\t  ");
        $this->assertSame([], $chunks, 'Whitespace-only input should yield no chunks.');
    }

    public function testSingleHeaderCreatesOneChunkWithinSize(): void
    {
        $markdown = <<<MD
# Title
This is a small paragraph with a few words.
MD;

        $splitter = new MarkdownSplitter(chunkSize: 50);
        $chunks = $splitter->chunk($markdown);

        $this->assertCount(1, $chunks, 'Small document should result in a single chunk.');
        $this->assertInstanceOf(Chunk::class, $chunks[0]);
        $this->assertSame(MarkdownSplitter::class, $chunks[0]->getMetadataValue('type'));

        $text = $chunks[0]->getText();
        $this->assertStringContainsString('# Title', $text);
        $this->assertStringContainsString('This is a small paragraph', $text);
    }

    public function testMultipleHeadersMergesUntilWordLimitThenSplits(): void
    {
        // We craft 3 sections; chunkSize is low to force at least 2 chunks.
        $markdown = <<<MD
# Section 1
one two three four five
six seven

## Section 2
eight nine ten eleven twelve
thirteen fourteen fifteen

### Section 3
sixteen seventeen eighteen nineteen twenty
MD;

        // chunkSize in words; keep small to force split by blocks
        $splitter = new MarkdownSplitter(chunkSize: 12);
        $chunks = $splitter->chunk($markdown);

        // Expect at least 2 chunks because the total content exceeds 12 words.
        $this->assertGreaterThanOrEqual(2, count($chunks), 'Should split into multiple chunks based on word limit.');

        // Check types and metadata
        foreach ($chunks as $chunk) {
            $this->assertInstanceOf(Chunk::class, $chunk);
            $this->assertSame(MarkdownSplitter::class, $chunk->getMetadataValue('type'));
        }

        // Basic content continuity checks
        $all = implode("\n---\n", array_map(fn(Chunk $c) => $c->getText(), $chunks));
        $this->assertStringContainsString('# Section 1', $all);
        $this->assertStringContainsString('## Section 2', $all);
        $this->assertStringContainsString('### Section 3', $all);
        $this->assertStringContainsString('one two three', $all);
        $this->assertStringContainsString('sixteen seventeen', $all);
    }

    public function testLineEndingNormalizationWindowsAndOldMac(): void
    {
        // Mix of \r\n and \r endings should be normalized by the splitter.
        $markdown = "# A Title\r\nLine 1 of content\rLine 2 of content\r\nLine 3";

        $splitter = new MarkdownSplitter(chunkSize: 50);
        $chunks = $splitter->chunk($markdown);

        $this->assertCount(1, $chunks, 'Normalized EOLs should not affect chunking for small input.');
        $text = $chunks[0]->getText();

        // The implementation appends PHP_EOL for content lines and ensures header + newline separation.
        $this->assertStringContainsString("# A Title\n", str_replace("\r\n", "\n", $text), 'Header should be separated by a newline.');
        $this->assertStringContainsString("Line 1 of content", $text);
        $this->assertStringContainsString("Line 2 of content", $text);
        $this->assertStringContainsString("Line 3", $text);
    }

    public function testBoldStyleHeaderDetection(): void
    {
        // Bold/strong header line pattern: **Header** or ***Header***
        $markdown = <<<MD
**My Bold Header**
Alpha beta gamma.

***Another Header***
Delta epsilon.
MD;

        // Keep small to potentially split if necessary; here it should still be 2 blocks possibly merged or split.
        $splitter = new MarkdownSplitter(chunkSize: 6);
        $chunks = $splitter->chunk($markdown);

        $this->assertGreaterThanOrEqual(1, count($chunks));
        $joined = implode("\n---\n", array_map(fn(Chunk $c) => $c->getText(), $chunks));

        $this->assertStringContainsString('**My Bold Header**', $joined);
        $this->assertStringContainsString('***Another Header***', $joined);
        $this->assertStringContainsString('Alpha beta gamma.', $joined);
        $this->assertStringContainsString('Delta epsilon.', $joined);
    }

    public function testSingleLargeBlockExceedingLimitIsNotInternallyResplit(): void
    {
        // A single header + a long paragraph that exceeds chunkSize.
        // Current strategy concatenates blocks but does not split inside a block.
        $markdown = "# Long\n" . str_repeat("word ", 100); // ~100 words in one block

        $splitter = new MarkdownSplitter(chunkSize: 20);
        $chunks = $splitter->chunk($markdown);

        // Because there is only one parsed block, the result should be exactly one Chunk,
        // even if it exceeds the configured chunk size.
        $this->assertCount(1, $chunks, 'A single large block is not internally split by the current strategy.');

        $text = $chunks[0]->getText();
        $this->assertStringContainsString('# Long', $text);
        $this->assertGreaterThan(20, str_word_count($text), 'Resulting single chunk should exceed the chunkSize in words.');
    }

    public function testSplitAcrossBlocksRespectsWordBudget(): void
    {
        // Three small blocks; ensure merge happens up to capacity, then new chunk starts on overflow.
        $markdown = <<<MD
# H1
one two three four five

## H2
six seven eight nine ten

### H3
eleven twelve thirteen fourteen fifteen
MD;

        // chunkSize=9 words forces: [H1+content] + (H2+content) likely to start a new chunk when budget exceeded.
        $splitter = new MarkdownSplitter(chunkSize: 9);
        $chunks = $splitter->chunk($markdown);

        $this->assertGreaterThanOrEqual(2, count($chunks));

        // First chunk should contain H1 and at least part of its content
        $c1 = $chunks[0]->getText();
        $this->assertStringContainsString('# H1', $c1);
        $this->assertStringContainsString('one two three', $c1);

        // Subsequent chunk should start with H2 (since we split by blocks)
        $c2 = $chunks[1]->getText();
        $this->assertStringContainsString('## H2', $c2);

        // And if a third chunk exists, it should start with H3
        if (isset($chunks[2])) {
            $this->assertStringContainsString('### H3', $chunks[2]->getText());
        }
    }
}
