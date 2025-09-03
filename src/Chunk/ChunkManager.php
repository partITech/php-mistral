<?php
declare(strict_types=1);

namespace Partitech\PhpMistral\Chunk;

use InvalidArgumentException;
use Partitech\PhpMistral\Interfaces\ChunkInterface;
use Partitech\PhpMistral\Interfaces\ChunkStrategyInterface;

/**
 * Class ChunkManager
 *
 * Coordinates chunk creation by delegating to a pluggable strategy (Strategy pattern).
 * The manager receives a ChunkStrategyInterface and exposes a simple API to produce a ChunkCollection.
 *
 * Notes:
 * - Constants MODE_STRICT and MODE_GREEDY are reserved for future behavior toggles at the manager level.
 *   They are documented here for clarity even if not yet used.
 */
class ChunkManager
{
    /**
     * The strategy responsible for turning raw text into an array of ChunkInterface instances.
     *
     * Using readonly prevents accidental re-assignment after construction.
     */
    private readonly ChunkStrategyInterface $strategy;

    /**
     * Reserved mode for strict chunking behavior (e.g., hard boundaries).
     */
    public const MODE_STRICT = 0;

    /**
     * Reserved mode for greedy chunking behavior (e.g., try to maximize chunk size).
     */
    public const MODE_GREEDY = 1;

    /**
     * @param ChunkStrategyInterface $strategy The chunking strategy to use.
     */
    public function __construct(ChunkStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Create a collection of chunks from the provided text.
     *
     * @param string $text The raw input text to be chunked.
     *
     * @return ChunkCollection A collection packaging the produced chunks alongside the original content.
     *
     * @throws InvalidArgumentException If the strategy returns non-chunk items.
     */
    public function createChunks(string $text): ChunkCollection
    {
        // Delegate the chunking operation to the injected strategy.
        $chunks = $this->strategy->chunk($text);

        // Defensive programming: ensure the strategy returned only ChunkInterface instances.
        // Improvement: Failing early here produces a clearer error than deferring to consumers.
        foreach ($chunks as $i => $chunk) {
            if (!$chunk instanceof ChunkInterface) {
                throw new InvalidArgumentException(sprintf(
                    'Chunk strategy "%s" returned an invalid element at index %d; expected %s.',
                    $this->strategy::class,
                    $i,
                    ChunkInterface::class
                ));
            }
        }

        // Wrap in a ChunkCollection, preserving the original text for traceability.
        return new ChunkCollection($chunks, $text);
    }
}