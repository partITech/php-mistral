<?php

namespace Tests\Functional\InferenceServices\Mistral;

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Clients\Mistral\MistralDocumentClient;
use Partitech\PhpMistral\Log\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\TestCleanupTrait;
use Tests\Traits\TestConsoleOutputTrait;

/**
 * Class Setup
 * This class is a functional test setup for Mistral inference services.
 * It inherits PHPUnit's TestCase and includes traits for console output and cleanup functionality.
 */
class Setup extends TestCase
{
    // Traits used to extend functionality for console output and test cleanup during teardown.
    use TestConsoleOutputTrait;
    use TestCleanupTrait;

    /**
     * @var MistralClient $client
     * Responsible for handling API requests to Mistral.
     */
    protected MistralClient $client;

    /**
     * @var MistralDocumentClient $client
     * Responsible for handling Documents API requests to Mistral.
     */
    protected MistralDocumentClient $documentClient;

    /**
     * @var string $model
     * Stores the model name used for testing (e.g., chat model configured via environment variables).
     */
    protected string $model;

    /**
     * setUp method
     * Automatically executed before each test case.
     *
     * This method initializes the MistralClient with the API key
     * and sets up the appropriate model for testing based on environment variables.
     */
    protected function setUp(): void
    {
        // Retrieve the MISTRAL_API_KEY from environment variables.
        $apiKey = getenv('MISTRAL_API_KEY');

        // Retrieve the MISTRAL_CHAT_MODEL from environment variables for model selection.
        $chatModel = getenv('MISTRAL_CHAT_MODEL');

        // Initialize the MistralClient with the provided API key.
        $this->client = new MistralClient(apiKey: $apiKey);

        // Initialize the MistralDocumentClient with the provided API key.
        $this->documentClient = new MistralDocumentClient(apiKey: $apiKey);

        // Attach a logger to the MistralClient instance for logging purposes.
        $this->client->setLogger(LoggerFactory::create());

        // Set the model for use in the tests.
        $this->model = $chatModel;
    }
}