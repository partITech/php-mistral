<?php

declare(strict_types=1);

namespace KnpLabs\JsonSchema;

/**
 * @template E
 *
 * @implements JsonSchemaInterface<E>
 */
abstract class EnumSchema implements JsonSchemaInterface
{
    /**
     * @return iterable<int, E>
     */
    abstract protected function getEnum(): iterable;

    public function getExamples(): iterable
    {
        return $this->getEnum();
    }

    public function getSchema(): array
    {
        return [
            'enum' => [...$this->getEnum()],
        ];
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
