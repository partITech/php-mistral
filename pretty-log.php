#!/usr/bin/env php
<?php

// Open the standard input stream (PHP's virtual "php://stdin")
$stdin = fopen('php://stdin', 'r');
if (!$stdin) {
    // If stdin can't be opened, output error to STDERR and terminate.
    fwrite(STDERR, "Unable to open stdin\n");
    exit(1);
}

// Process the input stream line by line
while (!feof($stdin)) {
    $line = fgets($stdin); // Read a line from stdin
    if ($line === false) {
        // No new line detected yet: wait briefly before retrying
        usleep(100_000); // Sleep for 100 milliseconds
        continue;
    }
    $line = rtrim($line, "\r\n"); // Trim any trailing newlines (\r\n)

    // 1) Separate the prefix before the first opening brace '{'
    $pos = strpos($line, '{');
    if ($pos === false) {
        // If no '{' is found, output the raw line as-is
        echo $line, "\n";
        continue;
    }
    $prefix = substr($line, 0, $pos); // Extract the prefix
    $rest   = substr($line, $pos);   // Extract the rest of the line starting from '{'

    // 2) Extract all {...} blocks recursively using a PCRE regex (pattern matching)
    if (preg_match_all('/\{(?:[^{}]*|(?R))*\}/', $rest, $m)) {
        foreach ($m[0] as $json) {
            // Decode JSON and validate its structure
            $data = json_decode($json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // If not valid JSON, output the raw line
                echo $line, "\n";
                continue;
            }
            // 3) Pretty-print the decoded JSON
            $pretty = json_encode(
                $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );
            // 4) Output each pretty-printed line with its prefix
            foreach (explode("\n", $pretty) as $l) {
                echo $l, "\n";
            }
        }
    } else {
        // If no JSON was found, output the raw line
        echo $line, "\n";
    }
}