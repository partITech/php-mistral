<?php
namespace Partitech\PhpMistral\Clients\Mistral;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use OutOfBoundsException;

class MistralLibraries implements IteratorAggregate, Countable, ArrayAccess
{
    /** @var MistralConversation[] */
    private array $items;

    public function __construct(array $libraries)
    {
        $this->items = $libraries;
    }

    public static function fromArray(array $data): self
    {
        $libraries = array_map(
            fn(array $c) => MistralLibrary::fromArray($c),
            $data['data']
        );
        return new self($libraries);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function first(): ?MistralConversation
    {
        return $this->items[0] ?? null;
    }

    public function last(): ?MistralConversation
    {
        return $this->items[count($this->items) - 1] ?? null;
    }

    public function getItem(int $index): MistralLibrary
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

    public function offsetGet($offset): MistralLibrary
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
     * Add a MistralLibrary to the collection.
     *
     * @param MistralLibrary $library The library to add.
     * @return self
     */
    public function add(MistralLibrary $library): self
    {
        $this->items[] = $library;
        return $this;
    }

    public function getById(string $id): ?MistralLibrary
    {
        foreach ($this->items as $library) {
            if ($library->getId() === $id) {
                return $library;
            }
        }
        return null;
    }

}
