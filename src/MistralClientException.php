<?php

namespace Partitech\PhpMistral;

use Exception;
use Throwable;

class MistralClientException extends Exception
{
    public function __construct(string $message, int $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}