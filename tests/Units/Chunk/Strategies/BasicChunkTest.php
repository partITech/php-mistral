<?php

namespace Tests\Units\Chunk\Strategies;


use PHPUnit\Framework\TestCase;
use Partitech\PhpMistral\Chunk\ChunkManager;
use Partitech\PhpMistral\Chunk\Strategies\BasicChunk;


/**
 * @covers \Partitech\PhpMistral\Chunk\Strategies\BasicChunk
 */
final class BasicChunkTest extends TestCase
{
    /**
     * Ensure strict mode creates fixed-size chunks with no overlap,
     * handles tail shorter than chunkSize, and sets metadata.
     */
    public function testStrictModeBasicChunking(): void
    {
        // 12 words, chunk size = 5 -> expect [5, 5, 2]
        $text = 'one two three four five six seven eight nine ten eleven twelve';

        $chunker = new BasicChunk(chunkSize: 5, overlap: 0, mode: ChunkManager::MODE_STRICT);
        $chunks = $chunker->chunk($text);

        $this->assertCount(3, $chunks, 'Should produce 3 chunks in strict mode.');
        $this->assertSame('one two three four five', $chunks[0]->getText());
        $this->assertSame('six seven eight nine ten', $chunks[1]->getText());
        $this->assertSame('eleven twelve', $chunks[2]->getText());

        // Metadata checks
        $this->assertSame(BasicChunk::class, $chunks[0]->getMetadataValue('type'));
        $this->assertSame(ChunkManager::MODE_STRICT, $chunks[0]->getMetadataValue('mode'));
        $this->assertSame(5, $chunks[0]->getMetadataValue('size'));
        $this->assertSame(0, $chunks[0]->getMetadataValue('overlap'));
        $this->assertSame(0, $chunks[0]->getMetadataValue('start'));
        $this->assertSame(5, $chunks[1]->getMetadataValue('start'));
        $this->assertSame(10, $chunks[2]->getMetadataValue('start'));
    }

    /**
     * Ensure greedy mode extends to the next sentence boundary (. ! ?),
     * and advances by chunkSize - overlap.
     */
    public function testGreedyModeExtendsToSentenceBoundaryAndOverlap(): void
    {
        // We keep sentences easy to inspect.
        $text = implode(' ', [
            'This is sentence one.',                        // sentence end after 'one.'
            'Here is sentence two which is longer.',        // another end after 'longer.'
            'Final short.'                                  // final sentence
        ]);

        // Base window = 5 words; overlap = 2 -> step = 3 words each iteration.
        $chunker = new BasicChunk(chunkSize: 5, overlap: 2, mode: ChunkManager::MODE_GREEDY);
        $chunks = $chunker->chunk($text);

        // At least two chunks expected given overlap stepping and extension to sentence boundary.
        $this->assertGreaterThanOrEqual(2, count($chunks));

        // First chunk: 5 words + extend to first sentence punctuation if present.
        $first = $chunks[0]->getText();
        $this->assertStringContainsString('This is sentence one.', $first, 'Greedy chunk should end at sentence boundary.');

        // Step should be chunkSize - overlap = 3 starting words between chunks.
        $this->assertSame(0, $chunks[0]->getMetadataValue('start'));
        $this->assertSame(3, $chunks[1]->getMetadataValue('start'), 'Greedy should advance by chunkSize - overlap.');

        // Metadata checks
        foreach ($chunks as $idx => $chunk) {
            $this->assertSame(BasicChunk::class, $chunk->getMetadataValue('type'));
            $this->assertSame(ChunkManager::MODE_GREEDY, $chunk->getMetadataValue('mode'));
            $this->assertSame(5, $chunk->getMetadataValue('size'));
            $this->assertSame(2, $chunk->getMetadataValue('overlap'));
            $this->assertIsInt($chunk->getMetadataValue('start'), "Chunk {$idx} should have integer 'start' metadata.");
        }
    }

    /**
     * Ensure empty input returns an empty array.
     */
    public function testEmptyInput(): void
    {
        $chunker = new BasicChunk();
        $this->assertSame([], $chunker->chunk(''));
        $this->assertSame([], $chunker->chunk("   \n\t  "));
    }

    /**
     * Ensure whitespace normalization (multiple spaces/newlines) does not break tokenization.
     */
    public function testWhitespaceNormalization(): void
    {
        $text = "one   two\tthree\nfour    five";
        $chunker = new BasicChunk(chunkSize: 2, overlap: 0, mode: ChunkManager::MODE_STRICT);
        $chunks = $chunker->chunk($text);

        $this->assertCount(3, $chunks);
        $this->assertSame('one two', $chunks[0]->getText());
        $this->assertSame('three four', $chunks[1]->getText());
        $this->assertSame('five', $chunks[2]->getText());
    }

    /**
     * Ensure constructor clamps invalid sizes and overlap to safe values.
     * - chunkSize < 1 becomes 1.
     * - overlap >= chunkSize becomes chunkSize - 1.
     */
    public function testConstructorGuardsAndClamps(): void
    {
        $c1 = new BasicChunk(chunkSize: 0, overlap: 0, mode: ChunkManager::MODE_STRICT);
        $this->assertSame(1, $c1->getChunkSize(), 'chunkSize should be clamped to at least 1.');

        $c2 = new BasicChunk(chunkSize: 5, overlap: 10, mode: ChunkManager::MODE_GREEDY);
        $this->assertSame(5, $c2->getChunkSize());
        $this->assertSame(4, $c2->getOverlap(), 'overlap should be clamped to chunkSize - 1.');
    }

    /**
     * Ensure unknown mode falls back to strict-like behavior without errors.
     */
    public function testUnknownModeFallsBackToStrictBehavior(): void
    {
        // Mode 999 is not defined -> should behave like strict.
        $chunker = new BasicChunk(chunkSize: 3, overlap: 1, mode: 999);
        $chunks = $chunker->chunk('a b c d e f g');

        $this->assertCount(3, $chunks);
        $this->assertSame('a b c', $chunks[0]->getText());
        $this->assertSame('d e f', $chunks[1]->getText());
        $this->assertSame('g', $chunks[2]->getText());
    }
}
