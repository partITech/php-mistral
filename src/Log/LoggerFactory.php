<?php

namespace Partitech\PhpMistral\Log;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\IntrospectionProcessor;
use Psr\Log\LoggerInterface;

/**
 * LoggerFactory
 *
 * A factory class for creating and managing loggers with pre-configured
 * handlers and processors.
 */
class LoggerFactory
{
    /**
     * Create a new logger instance.
     *
     * This method initializes a logger with specific handlers and processors.
     *
     * @param string $channel The name of the logging channel.
     * @param string $logPath The file path where logs will be written.
     *
     * @return LoggerInterface Returns the configured logger instance.
     */
    public static function create(string $channel = 'php-mistral', string $logPath = 'var/logs/php-mistral.log'): LoggerInterface
    {
        // Create a new logger with the specified channel name.
        $logger = new Logger($channel);

        // Create a file handler to write log entries to the specified file.
        $fileHandler = new StreamHandler($logPath, Level::Debug);

        // Add the file handler to the logger.
        $logger->pushHandler($fileHandler);

        // Add a unique identifier processor to the logger for better traceability.
        $logger->pushProcessor(new UidProcessor());

        // Add an introspection processor to include file and line information in log entries.
        $logger->pushProcessor(new IntrospectionProcessor(Level::Debug));

        // Return the fully configured logger.
        return $logger;
    }

    /**
     * Log an informational message.
     *
     * This method creates a logger instance and logs an informational message
     * with optional context data.
     *
     * @param string $message The log message.
     * @param array $context Additional contextual data for the log entry.
     *
     * @return void
     */
    public static function info(string $message, array $context = []): void
    {
        // Create a new logger instance using the default parameters.
        $logger = self::create();

        // Add an informational log entry with the provided message and context.
        $logger->info($message, $context);
    }
}