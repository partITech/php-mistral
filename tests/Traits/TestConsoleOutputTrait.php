<?php

namespace Tests\Traits;

/**
 * Trait TestConsoleOutputTrait
 *
 * Provides methods to output formatted messages to the console with various
 * message types (e.g., notes, success, warnings, errors, info). Uses ANSI escape
 * codes for coloring the output.
 */
trait TestConsoleOutputTrait
{
    /**
     * Outputs a formatted message to the console with a custom color.
     *
     * The method uses ANSI escape codes and allows messages to be styled and formatted
     * specifically. If the provided message is an array, it converts the array to a JSON
     * string for display.
     *
     * @param mixed  $message The message to output (can be a string or an array).
     * @param string $color   The ANSI color code for the message (default is '36' - cyan).
     * 
     * @return void
     */
    protected function consoleNote(mixed $message, string $color = '36'): void
    {
        // Convert the message to JSON if it's an array
        if (is_array($message)) {
            $message = json_encode($message, JSON_PRETTY_PRINT);
        }

        // Format the message with ANSI escape codes for color and styling
        $formatted = sprintf("\n\033[1;%sm🟢 %s\033[0m\n", $color, $message);

        // Write the formatted message to the standard output (console)
        fwrite(STDOUT, $formatted);
    }

    /**
     * Outputs a success message to the console.
     *
     * @param string $message The success message.
     * 
     * @return void
     */
    protected function consoleSuccess(string $message): void
    {
        // Green color code (ANSI: '32')
        $this->consoleNote("✅ $message", '32');
    }

    /**
     * Outputs a warning message to the console.
     *
     * @param string $message The warning message.
     * 
     * @return void
     */
    protected function consoleWarning(string $message): void
    {
        // Yellow color code (ANSI: '33')
        $this->consoleNote("⚠️ $message", '33');
    }

    /**
     * Outputs an error message to the console.
     *
     * @param string $message The error message.
     * 
     * @return void
     */
    protected function consoleError(string $message): void
    {
        // Red color code (ANSI: '31')
        $this->consoleNote("❌ $message", '31');
    }

    /**
     * Outputs an informational message to the console.
     *
     * @param string $message The informational message.
     * 
     * @return void
     */
    protected function consoleInfo(string $message): void
    {
        // Blue color code (ANSI: '34')
        $this->consoleNote("ℹ️ $message", '34');
    }
}