<?php
namespace Tests\Functional\InferenceServices\Xai;

use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Log\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\TestCleanupTrait;
use Tests\Traits\TestConsoleOutputTrait;

/**
 * Class Setup
 *
 * Functional test setup for XAI Service testing.
 * Handles initialization of the XAiClient and mandatory configurations.
 */
class Setup extends TestCase
{
    use TestConsoleOutputTrait; // Adds console output utilities
    use TestCleanupTrait;       // Adds cleanup functionality for test data

    /**
     * @var XAiClient The X.AI API client used for making API requests.
     */
    protected XAiClient $client;

    /**
     * @var string The model identifier used in the X.AI Service tests.
     */
    protected string $model;

    /**
     * SetUp method executed before each test.
     *
     * - Initializes the XAiClient with an API key.
     * - Configures the appropriate chat model.
     *
     * @return void
     */
    protected function setUp(): void
    {
        // Retrieve the API key from environment variables.
        $apiKey = getenv('XAI_API_KEY');
        // Retrieve the chat model identifier from environment variables.
        $chatModel = getenv('XAI_CHAT_MODEL');

        // Initialize the XAiClient with the retrieved API key.
        $this->client = new XAiClient(apiKey: $apiKey);

        // Set the logger for the client using LoggerFactory.
        $this->client->setLogger(LoggerFactory::create());

        // Assign the chat model identifier for usage in tests.
        $this->model = $chatModel;
    }
}