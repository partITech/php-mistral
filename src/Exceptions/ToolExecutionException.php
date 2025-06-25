<?php

namespace Partitech\PhpMistral\Exceptions;

use Exception;

/**
 * Class ToolExecutionException
 *
 * Exception thrown when there is an error during the execution of a specific tool.
 */
class ToolExecutionException extends Exception
{
    /**
     * ToolExecutionException constructor.
     *
     * @param string $toolName The name of the tool where the error occurred.
     * @param string $error A descriptive error message explaining the issue.
     * @param int $code An optional error code (defaults to 0).
     * @param Exception|null $previous An optional previous exception for exception chaining (can be null).
     */
    public function __construct(string $toolName, string $error, int $code = 0, ?Exception $previous = null)
    {
        // Prepare a detailed error message including the tool name and the error description
        $message = "Error while executing tool '{$toolName}': {$error}";

        // Call the parent Exception constructor for message, code, and exception chaining
        parent::__construct($message, $code, $previous);
    }
}