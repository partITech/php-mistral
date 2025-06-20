<?php

namespace Tests\Functional\InferenceServices\Anthropic;

use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Log\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\TestCleanupTrait;
use Tests\Traits\TestConsoleOutputTrait;

/**
 * Class Setup
 * Functional test setup for AnthropicClient.
 */
class Setup extends TestCase
{
    // Utilize traits for reusable testing functionality.
    use TestConsoleOutputTrait;
    use TestCleanupTrait;

    /**
     * @var AnthropicClient $client The client instance to interact with Anthropic API.
     */
    protected AnthropicClient $client;

    /**
     * @var string $model The name of the chat model used for testing.
     */
    protected string $model;

    /**
     * Setup method executed before each test.
     * It initializes the Anthropic client and configures it with necessary parameters.
     *
     * @return void
     */
    protected function setUp(): void
    {
        // Fetch the API key and chat model from environment variables.
        $apiKey = getenv('ANTHROPIC_API_KEY');
        $chatModel = getenv('ANTHROPIC_CHAT_MODEL');

        // Initialize the Anthropic client and configure it.
        $this->client = new AnthropicClient(apiKey: $apiKey);

        // Set up a logger for the client.
        $this->client->setLogger(LoggerFactory::create());

        // Assign the chat model.
        $this->model = $chatModel;
    }
}