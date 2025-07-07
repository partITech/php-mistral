<?php

declare(strict_types=1);

namespace KnpLabs\JsonSchema\Validator;

final class Error
{
    public function __construct(
        private string $path,
        private string $message
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
