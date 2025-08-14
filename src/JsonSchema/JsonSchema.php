<?php

namespace Partitech\PhpMistral\JsonSchema;

class JsonSchema extends \KnpLabs\JsonSchema\JsonSchema
{
    public static function text(): array
    {
        return [
            'type' => 'string',
            // minLength is unsupported on Mistral "La plateforme".
            // 'minLength' => 1,
        ];
    }

    public static function string(?string $format = null): array
    {
        $result = [
            ...self::text()
            // maxLength is unsupported on Mistral "La plateforme".
            // 'maxLength' => 255,
        ];

        if (null !== $format) {
            $result['format'] = $format;
        }

        return $result;
    }
    //https://json-schema.org/understanding-json-schema/reference/enum
    public static function enum(iterable $enum): array
    {
        return [
            'enum' => $enum,
        ];
    }

    //https://json-schema.org/understanding-json-schema/reference/const
    public static function const(mixed $value): array
    {
        return [
            'const' => $value,
        ];
    }

    //https://json-schema.org/understanding-json-schema/reference/null
    public static function null(): array
    {
        return [
            'type' => 'null',
        ];
    }

    // https://json-schema.org/understanding-json-schema/reference/string#regexp
    public static function pattern(string $pattern): array
    {
        return [
            'type'    => 'string',
            'pattern' => $pattern,
        ];
    }

    // https://json-schema.org/understanding-json-schema/reference/combining#allOf
    public static function allOf(...$schemas): array
    {
        return [
            'allOf' => $schemas,
        ];
    }

    // https://json-schema.org/understanding-json-schema/reference/combining#anyOf
    public static function anyOf(...$schemas): array
    {
        return [
            'anyOf' => $schemas,
        ];
    }


    // https://json-schema.org/understanding-json-schema/reference/combining#oneOf
    public static function oneOf(...$schemas): array
    {
        return [
            'oneOf' => $schemas,
        ];
    }

    // https://json-schema.org/understanding-json-schema/reference/combining#not
    public static function not($schema): array
    {
        return [
            'not' => $schema,
        ];
    }
}