<?php
namespace Partitech\PhpMistral\Clients\Mistral;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use OutOfBoundsException;

class MistralDocuments implements IteratorAggregate, Countable, ArrayAccess
{
    /** @var MistralDocument[] */
    private array $items;

    public function __construct(array $documents)
    {
        $this->items = $documents;
    }

    public static function fromArray(array $data): self
    {
        $documents = array_map(
            fn(array $c) => MistralDocument::fromArray($c),
            $data
        );
        return new self($documents);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function first(): ?MistralDocument
    {
        return $this->items[0] ?? null;
    }

    public function last(): ?MistralDocument
    {
        return $this->items[count($this->items) - 1] ?? null;
    }

    public function getItem(int $index): MistralDocument
    {
        if (!isset($this->items[$index])) {
            throw new OutOfBoundsException("Index $index is out of bounds.");
        }
        return $this->items[$index];
    }

    // ArrayAccess interface methods

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset): MistralDocument
    {
        if (!isset($this->items[$offset])) {
            throw new OutOfBoundsException("Index $offset is out of bounds.");
        }
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * Add a MistralDocument to the collection.
     *
     * @param MistralDocument $document The document to add.
     * @return self
     */
    public function add(MistralDocument $document): self
    {
        $this->items[] = $document;
        return $this;
    }

}