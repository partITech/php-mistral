<?php

declare(strict_types=1);

namespace KnpLabs\JsonSchema\Validator;

use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<Error>
 */
final class Errors implements Countable, IteratorAggregate
{
    /**
     * @var array<Error>
     */
    private array $errors;

    public function __construct(Error ...$errors)
    {
        $this->errors = $errors;
    }

    public function count(): int
    {
        return \count($this->errors);
    }

    /**
     * @return ArrayIterator<int, Error>
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->errors);
    }
}
