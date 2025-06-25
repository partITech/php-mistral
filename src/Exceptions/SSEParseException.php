<?php

namespace Partitech\PhpMistral\Exceptions;

use Exception;

/**
 * Class SSEParseException
 *
 * Thrown when errors related to parsing or processing Server-Sent Events (SSE) streams occur.
 */
class SSEParseException extends Exception
{
    /**
     * SSEParseException constructor.
     *
     * @param string $message Descriptive error message.
     * @param int $code Error code (defaults to 0).
     * @param Exception|null $previous Previous exception for exception chaining (can be null).
     */
    public function __construct(string $message, int $code = 0, ?Exception $previous = null)
    {
        // Call the parent Exception constructor to initialize the error message, code, and previous exception
        parent::__construct($message, $code, $previous);
    }
}