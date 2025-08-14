<?php

namespace Partitech\PhpMistral\Tools;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

final class ToolCallCollection implements IteratorAggregate, JsonSerializable
{
    /** @var ToolCallFunction[] */
    private array $calls = [];

    public function __construct(array $calls = [])
    {
        foreach ($calls as $call) {
            if ($call instanceof ToolCallFunction) {
                $this->calls[] = $call;
            } else {
                $this->calls[] = ToolCallFunction::fromArray($call);
            }
        }
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->calls);
    }

    public function isEmpty(): bool
    {
        return empty($this->calls);
    }

    public function first(): ?ToolCallFunction
    {
        return $this->calls[0] ?? null;
    }

    public function toArray(): array
    {
        return array_map(fn(ToolCallFunction $c) => $c->toArray(), $this->calls);
    }

    public function add(ToolCallFunction|array $call): void
    {
        if ($call instanceof ToolCallFunction) {
            $this->calls[] = $call;
        } else {
            $this->calls[] = ToolCallFunction::fromArray($call);
        }
    }

    public function updateArguments(int $index, array $arguments): void
    {
        // if only one call directly update the call
        // note: bug with vllm and mistral. index changing during stream, so if only one call
        // directly update the only call
        if(count($this->calls) === 1){
            $this->calls[0]->updateArguments($arguments);
            return;
        }
        // if more than one call, find the call with the given index.
        foreach ($this->calls as $call) {
            if ($call->index === $index) {
                $call->updateArguments($arguments); // Directly update the arguments.
                return;
            }
        }



        throw new InvalidArgumentException("No ToolCallFunction found with index {$index}.");
    }

    public function count(): int
    {
        return count($this->calls);
    }

    public function jsonSerialize(): array
    {
        return $this->calls;
    }
}
