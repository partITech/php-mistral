<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Chunk\Strategies;

use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Interfaces\ChunkStrategyInterface;

/**
 * Splits Markdown text into semantically coherent chunks by detecting headers
 * and then merging/splitting content based on a maximum word count.
 *
 * Notes:
 * - The $chunkSize parameter controls the maximum number of words per chunk (not LLM tokens).
 * - Headers recognized: Markdown ATX headers (# to ####) and bold/strong-style titles (**Title** or ***Title***).
 */
class MarkdownSplitter implements ChunkStrategyInterface
{
    /**
     * Maximum number of words allowed per resulting chunk.
     *
     * IMPORTANT: This is a word count, not an LLM token count.
     * If you need token-based control, replace str_word_count with a proper tokenizer.
     */
    private int $chunkSize;

    /**
     * Immutable set of regex patterns used to detect headers in Markdown.
     * Converted to a constant to avoid accidental mutations (good practice).
     */
    private const HEADER_PATTERNS = [
        // Headers surrounded by ** or *** e.g., **Header** or ***Header***
        '/^\*{2,3}([^*]+)\*{2,3}$/',
        // ATX-style headers: # Header, ## Header, ### Header, #### Header
        '/^#{1,4}\s+(.+)$/',
    ];

    /**
     * @param int $chunkSize Maximum number of words per chunk. Default: 400.
     */
    public function __construct(int $chunkSize = 400)
    {
        $this->chunkSize = $chunkSize;
    }

    /**
     * Determines if a given line is a header according to HEADER_PATTERNS.
     *
     * @param string $line The line to test.
     * @return bool True if the line matches a header pattern, otherwise false.
     */
    private function isHeader(string $line): bool
    {
        $trimmed = trim($line);

        foreach (self::HEADER_PATTERNS as $pattern) {
            if (preg_match($pattern, $trimmed)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Parses Markdown into logical blocks keyed by "header" and "content".
     * - When a header is found, it starts a new block.
     * - Content lines are accumulated until the next header.
     *
     * @param string $markdown Raw Markdown text.
     * @return array<int, array{header: (string|null), content: string}>
     *
     * Improvement: normalize line endings to "\n" to support Windows/Mac inputs consistently.
     */
    private function parseMarkdown(string $markdown): array
    {
        // Normalize line endings to avoid issues on Windows (\r\n) and old Mac (\r)
        $normalized = str_replace(["\r\n", "\r"], "\n", $markdown);

        $chunks = [];
        $currentChunk = ['header' => null, 'content' => ''];
        $lines = explode("\n", $normalized);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($this->isHeader($line)) {
                // Flush current content block before starting a new header block
                if ($currentChunk['content'] !== '') {
                    $chunks[] = $currentChunk;
                }

                $currentChunk = ['header' => $line, 'content' => ''];
            } else {
                // Preserve a single newline per source line for readability
                $currentChunk['content'] .= $line . PHP_EOL;
            }
        }

        // Flush the final block if it contains content
        if (!empty($currentChunk['content'])) {
            $chunks[] = $currentChunk;
        }

        return $chunks;
    }

    /**
     * Splits the input text into Chunk objects.
     * Strategy:
     * 1) Parse Markdown into (header, content) blocks.
     * 2) Concatenate blocks while the total word count does not exceed $chunkSize.
     * 3) Start a new Chunk when exceeding the limit.
     *
     * @param string $text The Markdown text to split.
     * @return array<int, Chunk> A list of Chunk objects with metadata['type'] = class name.
     *
     * Note: Uses str_word_count as an approximate measure (word-based, locale-dependent).
     * If you need deterministic behavior across locales, consider a custom tokenizer.
     */
    public function chunk(string $text): array
    {
        $parsedChunks = $this->parseMarkdown($text);

        $finalChunks = [];
        $currentChunkText = '';

        foreach ($parsedChunks as $chunk) {
            if(empty(trim($chunk['content']))){
                continue;
            }
            // Build combined text: header (if any) + content.
            // The extra newline ensures the header is visually separated from content.
            $header = $chunk['header'] ?? '';
            $combinedText = ($header !== '' ? $header . PHP_EOL : '') . $chunk['content'];

            $currentWords = str_word_count($currentChunkText);
            $combinedWords = str_word_count($combinedText);

            if (($currentWords + $combinedWords) <= $this->chunkSize) {
                // Safe to append to the current chunk
                $currentChunkText .= $combinedText;
            } else {
                // Flush current chunk if it has content
                if (!empty($currentChunkText)) {
                    $finalChunks[] = new Chunk($currentChunkText, [
                        'type' => self::class,
                    ]);
                }

                // Start a new chunk with the current block
                $currentChunkText = $combinedText;
            }
        }

        // Add the last chunk if present
        if (!empty(trim($currentChunkText))) {
            $finalChunks[] = new Chunk($currentChunkText, [
                'type' => self::class,
            ]);
        }

        return $finalChunks;
    }
}