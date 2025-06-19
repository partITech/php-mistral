<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Log\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\TestCleanupTrait;
use Tests\Traits\TestConsoleOutputTrait;

/**
 * Test case setup for functional tests of the OllamaClient.
 */
class Setup extends TestCase
{
    use TestConsoleOutputTrait; // Trait for handling console output during tests.
    use TestCleanupTrait;       // Trait for cleanup logic during tests.

    /**
     * OllamaClient instance.
     *
     * @var OllamaClient
     */
    protected OllamaClient $client;

    /**
     * Name of the model to be used in tests.
     *
     * @var string
     */
    protected string $model;

    /**
     * Set up resources for the test case.
     *
     * This method initializes the OllamaClient and retrieves the required OLLAMA_URL 
     * and OLLAMA_CHAT_MODEL from the environment. It throws an exception if these 
     * environment variables are not set or if the client cannot initialize properly.
     *
     * @throws MistralClientException When model initialization or client setup fails.
     */
    protected function setUp(): void
    {
        // Retrieve the URL and model name from environment variables.
        $chatInferenceUrl = getenv('OLLAMA_URL');
        $chatModel = getenv('OLLAMA_CHAT_MODEL');

        // Ensure the OLLAMA_URL environment variable is set.
        $this->assertNotEmpty(
            $chatInferenceUrl,
            'OLLAMA_URL is not set in the environment.'
        );

        // Ensure the OLLAMA_CHAT_MODEL environment variable is set.
        $this->assertNotEmpty(
            $chatModel,
            'OLLAMA_CHAT_MODEL is not set in the environment.'
        );

        // Assign the model name for later use.
        $this->model = $chatModel;

        // Initialize the Ollama client with the inference URL.
        $this->client = new OllamaClient(
            url: $chatInferenceUrl
        );

        // Ensure the required model is available.
        $this->client->requireModel($this->model);

        // Set up a logger for the client.
        $this->client->setLogger(LoggerFactory::create());
    }
}