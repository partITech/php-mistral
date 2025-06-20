<?php

namespace Tests\Functional\InferenceServices\HuggingFace;

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Log\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\TestCleanupTrait;
use Tests\Traits\TestConsoleOutputTrait;

/**
 * This class sets up the necessary components for functional tests
 * involving the HuggingFaceClient. It uses traits for reusable logic
 * and is designed to configure the HuggingFaceClient before tests are run.
 */
class Setup extends TestCase
{
    use TestConsoleOutputTrait; // Trait for console output functionalities
    use TestCleanupTrait;       // Trait for cleaning up test directories

    /**
     * Instance of the HuggingFaceClient to interact with Hugging Face API.
     *
     * @var HuggingFaceClient
     */
    protected HuggingFaceClient $client;

    /**
     * The model name used for Hugging Face chats.
     *
     * @var string
     */
    protected string $model;

    /**
     * Setup method executed before each test to initialize required components.
     *
     * @return void
     */
    protected function setUp(): void
    {
        // Fetch the Hugging Face API key from environment variables
        $apiKey = getenv('HF_TOKEN');

        // Fetch the model name for chats from environment variables
        $chatModel = getenv('HF_CHAT_MODEL');

        // Initialize the HuggingFaceClient with API key and provider
        $this->client = new HuggingFaceClient(apiKey: $apiKey, provider: 'hf-inference');

        // Set the logger for the HuggingFaceClient using a factory
        $this->client->setLogger(LoggerFactory::create());

        // Assign the chat model from the environment variable
        $this->model = $chatModel;
    }
}