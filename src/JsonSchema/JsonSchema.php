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
}