<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/SimpleListSchema.php';

$dotenv = new Dotenv();
$dotenv->usePutenv();
$dotenv->load(__DIR__ . '/../.env');

function note(string $message, string $color = '34'): void
{
    fwrite(STDOUT, "\n\033[1;{$color}m🟣 $message\033[0m\n");
}



