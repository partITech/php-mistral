<?php

declare(strict_types=1);

namespace KnpLabs\JsonSchema;

use Exception;

final class Collection
{
    /**
     * @param iterable<JsonSchemaInterface<mixed>> $schemas
     */
    public function __construct(private iterable $schemas)
    {
    }

    /**
     * @template J of JsonSchemaInterface
     *
     * @param class-string<J> $schemaClassName
     *
     * @return J
     */
    public function get(string $schemaClassName): JsonSchemaInterface
    {
        foreach ($this->schemas as $schema) {
            if (is_a($schema, $schemaClassName)) {
                return $schema;
            }
        }

        throw new Exception("Schema {$schemaClassName} not found.");
    }
}
