<?php

declare(strict_types=1);

namespace KnpLabs\JsonSchema;

/**
 * @template T of mixed
 *
 * @implements JsonSchemaInterface<T>
 */
class JsonSchema implements JsonSchemaInterface
{
    private function __construct(
        protected readonly string $title,
        protected readonly string $description,
        protected readonly iterable $examples,
        protected readonly array $schema
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getExamples(): iterable
    {
        yield from $this->examples;
    }

    public function getSchema(): array
    {
        return $this->schema;
    }

    /**
     * @template E of mixed
     * @param JsonSchemaInterface<E> $schema
     *
     * @return JsonSchema<null|E>
     */
    public static function nullable(JsonSchemaInterface $schema): self
    {
        return self::create(
            sprintf('Nullable<%s>', $schema->getTitle()),
            $schema->getDescription(),
            [...$schema->getExamples(), null],
            ['oneOf' => [self::null(), $schema->jsonSerialize()]],
        );
    }

    /**
     * @param iterable<int, E>     $examples
     * @param array<string, mixed> $schema
     * @template E of mixed
     *
     * @return JsonSchema<E>
     */
    public static function create(
        string $title,
        string $description,
        iterable $examples,
        array $schema
    ): self {
        return new self($title, $description, $examples, $schema);
    }

    /**
     * @template I
     *
     * @param JsonSchemaInterface<I> $jsonSchema
     *
     * @return JsonSchema<array<int, I>>
     */
    public static function collection(JsonSchemaInterface $jsonSchema): self
    {
        return self::create(
            sprintf('Collection<%s>', $jsonSchema->getTitle()),
            $jsonSchema->getDescription(),
            [[...$jsonSchema->getExamples()]],
            [
                'type' => 'array',
                'items' => $jsonSchema,
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

    /**
     * @param scalar $value
     *
     * @return array<string, mixed>
     */
    public static function constant($value): array
    {
        return [
            'const' => $value,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function null(): array
    {
        return [
            'type' => 'null',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function text(): array
    {
        return [
            'type' => 'string',
            'minLength' => 1,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function boolean(): array
    {
        return [
            'type' => 'boolean',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function string(?string $format = null): array
    {
        $result = [
            ...self::text(),
            'maxLength' => 255,
        ];

        if (null !== $format) {
            $result['format'] = $format;
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    public static function integer(): array
    {
        return [
            'type' => 'integer',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function number(): array
    {
        return [
            'type' => 'number',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function date(): array
    {
        return [
            'type' => 'string',
            'format' => 'date',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function positiveInteger(): array
    {
        return [
            ...self::integer(),
            'exclusiveMinimum' => 0,
        ];
    }

    /**
     * @param array<string, mixed> ...$schemas
     *
     * @return array{oneOf: array<array<string, mixed>>}
     */
    public static function oneOf(...$schemas): array
    {
        return [
            'oneOf' => $schemas,
        ];
    }
}
