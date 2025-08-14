<?php

namespace Tests\Functional\Clients\Tgi;

use Partitech\PhpMistral\Clients\Tgi\TgiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Log\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\TestCleanupTrait;
use Tests\Traits\TestConsoleOutputTrait;

/**
 * Class Setup
 *
 * Functional test setup for testing TGI (Text Generation Inference) client.
 */
class Setup extends TestCase
{
    use TestConsoleOutputTrait;  // Provides helper methods for console output during tests.
    use TestCleanupTrait;       // Includes methods for resource cleanup after tests.

    /** @var TgiClient The TGI client to be used in tests */
    protected TgiClient $client;

    /** @var string Path to the variable directory for test resources */
    protected string $varPath;

    /** @var string Model used for text generation inference */
    protected string $model;

    /**
     * Set up the test environment before each test.
     *
     * This method initializes the TGI client with environment variables and
     * verifies required configurations.
     *
     * @throws MistralClientException If the client cannot be initialized.
     */
    protected function setUp(): void
    {
        // Resolve the path to the test variable directory
        $this->varPath = realpath('./tests/var');

        // Retrieve environment variables required for TGI client
        $chatInferenceUrl = getenv('TGI_CHAT_URL'); // URL to the chat inference API
        $chatModel        = getenv('TGI_CHAT_MODEL'); // Model identifier (e.g., GPT version)
        $apiKey           = getenv('TGI_API_KEY'); // API key for authentication

        // Assert that critical environment variables are set
        $this->assertNotEmpty(
            $chatInferenceUrl,
            'TGI_CHAT_URL is not set in the environment.' // Error if TGI_CHAT_URL is missing
        );
        $this->assertNotEmpty(
            $chatModel,
            'TGI_CHAT_MODEL is not set in the environment.' // Error if TGI_CHAT_MODEL is missing
        );

        // Bind the validated model information and initialize the TGI client
        $this->model = $chatModel;
        $this->client = new TgiClient(
            apiKey: $apiKey,          // Pass the API key to the client instance
            url: $chatInferenceUrl    // Set the API URL for the client
        );

        // Configure logging for the client
        $this->client->setLogger(LoggerFactory::create());
    }
}