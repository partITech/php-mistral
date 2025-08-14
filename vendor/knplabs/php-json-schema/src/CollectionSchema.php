<?php

declare(strict_types=1);

namespace KnpLabs\JsonSchema;

/**
 * @template I
 *
 * @type CollectionSchemaData array<I>
 *
 * @implements JsonSchemaInterface<CollectionSchemaData>
 */
abstract class CollectionSchema implements JsonSchemaInterface
{
    /**
     * @psalm-param JsonSchemaInterface<I> $itemSchema
     */
    public function __construct(private JsonSchemaInterface $itemSchema)
    {
    }

    public function getExamples(): iterable
    {
        yield [...$this->itemSchema->getExamples()];
    }

    public function getTitle(): string
    {
        return sprintf('Collection<%s>', $this->itemSchema->getTitle());
    }

    public function getDescription(): string
    {
        return sprintf('Collection of %s', $this->itemSchema->getDescription());
    }

    protected function getUniqueItems(): ?bool
    {
        return null;
    }

    protected function getMinLength(): ?int
    {
        return null;
    }

    protected function getMaxLength(): ?int
    {
        return null;
    }

    protected function getRange(): ?int
    {
        return null;
    }

    public function getSchema(): array
    {
        $schema = [
            'type' => 'array',
            'items' => $this->itemSchema->jsonSerialize(),
        ];

        if (null !== $uniqueItems = $this->getUniqueItems()) {
            $schema['uniqueItems'] = $uniqueItems;
        }

        if (null !== $minLength = $this->getMinLength()) {
            $schema['minLength'] = $minLength;
        }

        if (null !== $maxLength = $this->getMaxLength()) {
            $schema['maxLength'] = $maxLength;
        }

        return $schema;
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
