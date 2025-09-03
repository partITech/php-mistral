<?php

declare(strict_types=1);

namespace Partitech\PhpMistral\Chunk\Strategies;

use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Chunk\ChunkManager;
use Partitech\PhpMistral\Interfaces\ChunkStrategyInterface;

/**
 * BasicChunk
 *
 * Word-based chunking strategy with two modes:
 * - MODE_STRICT: produces fixed-size chunks with no overlap.
 * - MODE_GREEDY: produces fixed-size base chunks and extends to the next sentence boundary,
 *   then advances with an optional overlap.
 */
class BasicChunk implements ChunkStrategyInterface
{
    /** @var int Number of words per chunk window (base size). */
    private int $chunkSize;

    /** @var int Number of words to overlap between chunks (greedy mode). */
    private int $overlap;

    /** @var int Chunking mode (ChunkManager::MODE_STRICT or ::MODE_GREEDY). */
    private int $mode;

    /**
     * @param int $chunkSize Number of words per chunk (must be >= 1).
     * @param int $overlap   Overlap in greedy mode (0 <= overlap < chunkSize).
     * @param int $mode      One of ChunkManager::MODE_STRICT or ChunkManager::MODE_GREEDY.
     */
    public function __construct(int $chunkSize = 200, int $overlap = 0, int $mode = ChunkManager::MODE_STRICT)
    {
        // Ensure chunk size is valid; enforce minimal viable value.
        if ($chunkSize < 1) {
            $chunkSize = 1;
        }

        // Prevent infinite loops when overlap >= chunkSize in greedy mode.
        $overlap = max(0, min($overlap, $chunkSize - 1));

        $this->chunkSize = $chunkSize;
        $this->overlap = $overlap;

        // Fallback: if an unknown mode is provided, store strict mode to normalize behavior.
        $this->mode = in_array($mode, [ChunkManager::MODE_STRICT, ChunkManager::MODE_GREEDY], true)
            ? $mode
            : ChunkManager::MODE_STRICT;
    }

    /**
     * Split the given text into chunks based on the configured strategy.
     *
     * @param string $text Input text to be chunked.
     * @return array<Chunk> List of chunks.
     */
    public function chunk(string $text): array
    {
        // Normalize whitespace; early return if empty.
        $normalized = trim($text);
        if ($normalized === '') {
            return [];
        }

        // Robust word split: handles multiple spaces, newlines, tabs.
        $words = preg_split('/\s+/', $normalized);
        if (!is_array($words) || $words === []) {
            return [];
        }

        $chunks = [];
        $total = count($words);
        $i = 0;

        while ($i < $total) {
            $chunkText = '';

            if ($this->mode === ChunkManager::MODE_STRICT) {
                // Strict Mode: use the chunkSize with no overlap.
                $slice = array_slice($words, $i, $this->chunkSize);
                $chunkText = implode(' ', $slice);
            } elseif ($this->mode === ChunkManager::MODE_GREEDY) {
                // Greedy Mode: take chunkSize words, then extend to the next sentence boundary.
                $slice = array_slice($words, $i, $this->chunkSize);
                $chunkText = implode(' ', $slice);

                // Remaining words after the base window.
                $remainingWords = array_slice($words, $i + $this->chunkSize);
                if ($remainingWords) {
                    $remainingText = implode(' ', $remainingWords);

                    // Find earliest sentence boundary (. ! ?) and extend to it.
                    if (preg_match('/^(.+?[.!?])(\s|$)/u', $remainingText, $matches)) {
                        $chunkText .= ' ' . $matches[1];
                    }
                }
            } else {
                // Defensive default (should not happen because constructor normalizes mode):
                // behave like strict to avoid null/empty chunks and step mismatches.
                $slice = array_slice($words, $i, $this->chunkSize);
                $chunkText = implode(' ', $slice);
            }

            // Attach basic metadata for traceability and debugging.
            $metadata = [
                'type'    => self::class,
                'mode'    => $this->mode,
                'size'    => $this->chunkSize,
                'overlap' => $this->overlap,
                'start'   => $i, // starting word index in the tokenized text
            ];

            // Add chunk with content and metadata.
            $chunks[] = new Chunk($chunkText, $metadata);

            // Compute the next starting index:
            // - Strict: advance by chunkSize (no overlap).
            // - Greedy: advance by chunkSize - overlap (clamped to >= 1).
            $step = ($this->mode === ChunkManager::MODE_STRICT)
                ? $this->chunkSize
                : max(1, $this->chunkSize - $this->overlap);

            $i += $step;
        }

        return $chunks;
    }

    /**
     * Get the configured chunk size (words per base window).
     */
    public function getChunkSize(): int
    {
        return $this->chunkSize;
    }

    /**
     * Get the configured overlap (used in greedy mode).
     */
    public function getOverlap(): int
    {
        return $this->overlap;
    }

    /**
     * Get the current chunking mode.
     *
     * @return int One of ChunkManager::MODE_STRICT or ::MODE_GREEDY.
     */
    public function getMode(): int
    {
        return $this->mode;
    }
}