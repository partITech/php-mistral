<?php

namespace Partitech\PhpMistral\Exceptions;

use Throwable;
use Exception;

/**
 * Class MaximumRecursionException
 *
 * Exception thrown when the maximum recursion limit is reached.
 */
class MaximumRecursionException extends Exception
{
    /**
     * Constructor for MaximumRecursionException.
     *
     * @param string $message A custom error message (default: "Maximum recursion limit reached").
     * @param int $code The error code (default: 500).
     * @param Throwable|null $previous The previous throwable used for exception chaining (can be null).
     */
    public function __construct(
        string $message = "Maximum recursion limit reached",
        int $code = 500,
        ?Throwable $previous = null
    ) {
        // Call the parent Exception constructor to initialize the exception
        parent::__construct($message, $code, $previous);
    }
}