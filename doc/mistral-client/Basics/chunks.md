# Chunking API Documentation

## Introduction

The php-mistral "chunking" module splits a source text into coherent units (chunks) suitable for indexing, RAG, or any batch processing. It applies the Strategy Pattern: you choose a splitting strategy and the ChunkManager produces an ordered collection of chunks.

> \[!TIP]
> Splitting often improves retrieval relevance and LLM response stability by limiting the amount of context at once.

---

## Overview

* ChunkManager delegates splitting to an injected strategy.
* Each strategy returns a list of Chunk objects, later encapsulated in a ChunkCollection.
* Chunks contain text and metadata (uuid, index, etc.) for traceability.

| Element                | Role                                                                  |
| ---------------------- | --------------------------------------------------------------------- |
| ChunkManager           | Orchestration. Transforms text into a ChunkCollection via a strategy. |
| ChunkStrategyInterface | Contract for splitting strategies.                                    |
| Chunk                  | Unit of text + metadata (uuid, index, type, …).                       |
| ChunkCollection        | Ordered list of chunks + original content preservation.               |

> \[!NOTE]
> ChunkCollection assigns and normalizes the index of each chunk (metadata\["index"] = 0..N-1).

---

## Choosing a Strategy

| Strategy                       | Unit       | Features                                                                 | Use Cases                                           |
| ------------------------------ | ---------- | ------------------------------------------------------------------------ | --------------------------------------------------- |
| BasicChunk                     | Words      | STRICT and GREEDY modes, word overlap                                    | Flat text, sentence-respecting (GREEDY)             |
| MarkdownSplitter               | Words      | Detects Markdown headers, preserves section semantic coherence           | Structured documents (titles, sections)             |
| RecursiveCharacterTextSplitter | Characters | Hierarchical separators (paragraph > sentence > word), character overlap | Strict character-level control, heterogeneous texts |

> \[!WARNING]
> MarkdownSplitter does not re-split inside a single block: a very long block may exceed the budget (chunkSize).

---

## Quick Start

### BasicChunk — strict, greedy, and overlap (words)

```php
<?php
use Partitech\PhpMistral\Chunk\ChunkManager;
use Partitech\PhpMistral\Chunk\Strategies\BasicChunk;

$dataPath  = realpath(__DIR__ . '/../data/txt/');
$file      = $dataPath . '/lyft_2021.txt';
$content   = file_get_contents($file);

$chunkSize = 198; // words
$overlap   = 10;  // words

// 1) Strict: fixed windows of 198 words
$strategy = new BasicChunk(chunkSize: $chunkSize);
$manager  = new ChunkManager($strategy);
$collection = $manager->createChunks($content);

// 2) Greedy: 198 words then extended until end of sentence
$strategy = new BasicChunk(chunkSize: $chunkSize, mode: ChunkManager::MODE_GREEDY);
$manager  = new ChunkManager($strategy);
$collection = $manager->createChunks($content);

// 3) Overlap: 198 words with 10-word overlap
$strategy = new BasicChunk(chunkSize: $chunkSize, overlap: $overlap);
$manager  = new ChunkManager($strategy);
$collection = $manager->createChunks($content);

// 4) Overlap + Greedy
$strategy = new BasicChunk(chunkSize: $chunkSize, overlap: $overlap, mode: ChunkManager::MODE_GREEDY);
$manager  = new ChunkManager($strategy);
$collection = $manager->createChunks($content);
```

> \[!TIP]
> In GREEDY mode, the window shift from one to the next is (chunkSize - overlap).

---

### MarkdownSplitter — split by Markdown sections (word budget)

```php
<?php
use Partitech\PhpMistral\Chunk\ChunkManager;
use Partitech\PhpMistral\Chunk\Strategies\MarkdownSplitter;

$dataPath  = realpath(__DIR__ . '/../data/txt/');
$file      = $dataPath . '/lyft_2021.txt';
$content   = file_get_contents($file);

$chunkSize = 1000; // words (approximation)

$strategy   = new MarkdownSplitter(chunkSize: $chunkSize);
$manager    = new ChunkManager($strategy);
$collection = $manager->createChunks($content);

foreach ($collection->getChunks() as $chunk) {
    echo $chunk->getText() . PHP_EOL;
    echo str_repeat('#', 82) . PHP_EOL;
    if ($chunk->getIndex() > 1) {
        break;
    }
}
```

---

### RecursiveCharacterTextSplitter — hierarchical separators (character overlap)

```php
<?php
use Partitech\PhpMistral\Chunk\ChunkManager;
use Partitech\PhpMistral\Chunk\Strategies\RecursiveCharacterTextSplitter;

$dataPath  = realpath(__DIR__ . '/../data/txt/');
$file      = $dataPath . '/lyft_2021.txt';
$content   = file_get_contents($file);

$chunkSize = 1000; // characters
$overlap   = 150;  // characters

// Without overlap
$strategy   = new RecursiveCharacterTextSplitter(chunkSize: $chunkSize);
$manager    = new ChunkManager($strategy);
$collection = $manager->createChunks($content);

foreach ($collection->getChunks() as $chunk) {
    echo $chunk->getText() . PHP_EOL;
    echo str_repeat('#', 82) . PHP_EOL;
    if ($chunk->getMetadata()['index'] > 1) {
        break;
    }
}

// With 150-character overlap
$strategy   = new RecursiveCharacterTextSplitter(chunkSize: $chunkSize, overlap: $overlap);
$manager    = new ChunkManager($strategy);
$collection = $manager->createChunks($content);

foreach ($collection->getChunks() as $chunk) {
    echo $chunk->getText() . PHP_EOL;
    echo str_repeat('#', 82) . PHP_EOL;
    if ($chunk->getMetadata()['index'] > 1) {
        break;
    }
}
```

> \[!NOTE]
> By default, separators are hierarchical: paragraphs ("\n\n") > "." > " ". If a piece exceeds the budget, the process moves down one level.

---

## Reference API

### ChunkManager

* Role: coordinates splitting via the provided strategy.
* Key method:

    * createChunks(string \$text): ChunkCollection

```php
$manager = new ChunkManager($strategy);
$collection = $manager->createChunks($content);
```

> \[!WARNING]
> If the strategy returns non-conforming elements (non-Chunk), an InvalidArgumentException is thrown.

---

### Strategies

* BasicChunk

    * chunkSize: int (words)
    * overlap: int (words, 0 <= overlap < chunkSize)
    * mode: ChunkManager::MODE\_STRICT | ChunkManager::MODE\_GREEDY
    * Returns Chunks with metadata: type, mode, size, overlap, start

* MarkdownSplitter

    * chunkSize: int (words)
    * Detects headers (ATX: #..####, and **Title**/***Title***).
    * Does not re-split a single block even if too long.

* RecursiveCharacterTextSplitter

    * chunkSize: int (characters), overlap: int (characters)
    * separators: array (hierarchical order)
    * Returns normalized pieces (trimmed) + overlap concatenated to each chunk except the last.

---

### Chunk and Metadata

* Text: getText(): string
* Metadata: getMetadata(): array, getMetadataValue(), setMetadataValue()
* Index: getIndex(): int (set/normalized by the collection)
* UUID: available in metadata for traceability

```php
foreach ($collection->getChunks() as $chunk) {
    printf("#%d %s\n", $chunk->getIndex(), substr($chunk->getText(), 0, 80) . '...');
}
```

---

### ChunkCollection

* getChunks(): array
* getContent(): string (source text)
* count(): int
* addChunk(Chunk): void (automatically updates index)

> \[!TIP]
> Keep getContent() to audit results, reconstruct passages, or trace splits.

---

## Best Practices

* Choosing the budget:

    * Words (BasicChunk / MarkdownSplitter): practical for RAG and sentence-respecting (GREEDY).
    * Characters (RecursiveCharacterTextSplitter): useful for strict constraints (hard limits).
* Overlap:

    * Words for BasicChunk, characters for RecursiveCharacterTextSplitter.
    * Adjust based on context continuity needs. Avoid very large overlaps (memory cost).
* Markdown:

    * Ideal for structured documents. If sections are too long, consider secondary re-splitting.
* Performance:

    * Pre-process very large texts (stream files, upstream partitioning).
    * Quickly validate strategy output (unit tests provided).

---

## Extending: Create Your Own Strategy

```php
<?php
use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Interfaces\ChunkStrategyInterface;

final class MyCustomStrategy implements ChunkStrategyInterface
{
    public function __construct(private int $chunkSize = 800) {}

    public function chunk(string $text): array
    {
        $normalized = trim($text);
        if ($normalized === '') {
            return [];
        }

        // Simplified example: split by character size
        $parts = str_split($normalized, $this->chunkSize);

        return array_map(
            static fn(string $part) => new Chunk($part, ['type' => self::class]),
            $parts
        );
    }
}
```

Integration:

```php
$manager = new Partitech\PhpMistral\Chunk\ChunkManager(new MyCustomStrategy(800));
$collection = $manager->createChunks($content);
```
