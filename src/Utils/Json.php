<?php

namespace Partitech\PhpMistral\Utils;

final class Json
{
    public static function validate(string $json): bool
    {
        if (function_exists('json_validate')) {
            return json_validate($json);
        }

        // fallback PHP 8.2-
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }
}