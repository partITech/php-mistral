<?php

declare(strict_types=1);

namespace KnpLabs\JsonSchema;

use KnpLabs\JsonSchema\Validator\Errors;

interface Validator
{
    /**
     * @template T of array<array-key, mixed>
     *
     * @param array<array-key, mixed> $data
     * @param JsonSchemaInterface<T> $schema
     */
    public function validate(array $data, JsonSchemaInterface $schema): ?Errors;
}
