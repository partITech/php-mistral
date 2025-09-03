<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Chunk\Strategies;

use Partitech\PhpMistral\Interfaces\ChunkStrategyInterface;

class RecursiveCharacterTextSplitter implements ChunkStrategyInterface
{
    private int $chunkSize;
    private int $overlap;
    private array $separators;

    public function __construct(int $chunkSize = 200, int $overlap = 0, array $separators = ["\n\n", ".", " "])
    {
        $chunkSize = max(1, $chunkSize);
        $overlap = max(0, min($overlap, $chunkSize - 1));

        $this->chunkSize = $chunkSize;
        $this->overlap = $overlap;
        $this->separators = array_values($separators);
    }

    public function chunk(string $text): array
    {
        return $this->splitRecursive($text, 0);
    }

    public function splitRecursive(string $text, int $sepId): array
    {
        $separator = $this->separators[$sepId] ?? '';

        // Prepare results container
        $results = [];

        if ($separator === '') {
            // No more separators: split into fixed-size chunks
            $results = $this->splitIntoFixedSizeChunks($text, $this->chunkSize);

            // Apply root-level cleanup and overlaps if we are at top-level
            if ($sepId === 0) {
                $results = $this->removeEmptyResults($results);
                if ($this->overlap > 0) {
                    $results = $this->addOverlaps($results);
                }
            }

            return $results;
        }

        // Split by the current separator and inspect each piece
        $chunks = explode($separator, $text);
        foreach ($chunks as $chunk) {
            if (strlen($chunk) > $this->chunkSize && isset($this->separators[$sepId + 1])) {
                $newResult = $this->splitRecursive($chunk, $sepId + 1);
                $results = array_merge($results, $newResult);
            } else {
                $results[] = $chunk;
            }
        }

        // Root-level normalization and overlap
        if ($sepId === 0) {
            $results = $this->removeEmptyResults($results);
            if ($this->overlap > 0) {
                $results = $this->addOverlaps($results);
            }
        }

        return $results;
    }

    private function removeEmptyResults(array $chunks): array
    {
        $results = [];
        foreach ($chunks as $data) {
            $data = trim($data);
            if ($data === '') {
                continue;
            }
            $results[] = $data;
        }

        return $results;
    }

    public function addOverlaps(array $chunks): array
    {
        if ($this->overlap <= 0 || count($chunks) <= 1) {
            return $chunks;
        }

        $results = [];
        foreach ($chunks as $i => $chunk) {
            $overlap = $this->buildOverlapFromIndex($i + 1, $chunks);
            $results[] = $overlap === '' ? $chunk : rtrim($chunk . ' ' . $overlap);
        }

        return $results;
    }

    /**
     * Build overlap by concatenating subsequent chunks until reaching overlap length.
     * Truncate to exactly $this->overlap characters (byte-length).
     */
    private function buildOverlapFromIndex(int $startIndex, array $chunks): string
    {
        if (!isset($chunks[$startIndex]) || $this->overlap <= 0) {
            return '';
        }

        $acc = '';
        $idx = $startIndex;

        while (strlen($acc) < $this->overlap && isset($chunks[$idx])) {
            $acc .= ($acc === '' ? '' : ' ') . $chunks[$idx];
            $idx++;
        }

        if (strlen($acc) > $this->overlap) {
            return rtrim(substr($acc, 0, $this->overlap));
        }

        return $acc;
    }

    private function splitIntoFixedSizeChunks(string $text, int $size): array
    {
        if ($text === '') {
            return [];
        }

        return str_split($text, $size);
    }
}
