<?php

declare(strict_types=1);

namespace KnpLabs\JsonSchema\Scalar;

use KnpLabs\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\JsonSchemaInterface;

/**
 * @implements JsonSchemaInterface<string>
 */
final class UuidSchema implements JsonSchemaInterface
{
    private const PATTERN = '^[0-9a-f]{8}(-[0-9a-f]{4}){3}-[0-9a-f]{12}$';

    /**
     * {@inheritDoc}
     */
    public function getExamples(): iterable
    {
        yield '123e4567-e89b-12d3-a456-426614174000';
    }

    public function getTitle(): string
    {
        return 'Universally unique identifier';
    }

    public function getDescription(): string
    {
        return 'A universally unique identifier (UUID) is a 128-bit label used for information in computer systems.';
    }

    /**
     * {@inheritDoc}
     */
    public function getSchema(): array
    {
        return array_merge(
            JsonSchema::string(),
            [
                'pattern' => self::PATTERN,
                'minLength' => 36,
                'maxLength' => 36,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $schema = $this->getSchema();

        /**
         * @var array<string, mixed>&array{title: string, description: string, examples: array<T>}
         */
        return array_merge(
            $schema,
            [
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'examples' => [...$this->getExamples()],
            ],
        );
    }
}
