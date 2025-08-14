<?php

namespace Tests\Functional\Clients\vLLM;

use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\Log\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\TestCleanupTrait;
use Tests\Traits\TestConsoleOutputTrait;

/**
 * Class Setup
 *
 * Functional tests for initializing and setting up VllmClients.
 * 
 * @package Tests\Functional\Clients\vLLM
 */
class Setup extends TestCase
{
    use TestConsoleOutputTrait; // Trait for capturing test console output
    use TestCleanupTrait;      // Trait for cleaning up after tests

    /* Clients for handling different types of inference requests */
    protected VllmClient $client;
    protected VllmClient $visionClient;
    protected VllmClient $embeddingClient;

    /* Model names used for respective inference types */
    protected string $model;
    protected string $visionModel;
    protected string $embeddingModel;

    /**
     * setUp
     *
     * Initializes test configuration, environment variables, and VllmClients for various purposes.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        // Fetch environment variables required for initialization
        $chatInferenceUrl      = getenv('VLLM_CHAT_API_URL');
        $visionInferenceUrl    = getenv('VLLM_VISION_API_URL');
        $embeddingInferenceUrl = getenv('VLLM_EMBEDDING_API_URL');
        $apiKey                = getenv('API_KEY');
        $chatModel             = getenv('VLLM_CHAT_MODEL');
        $visionModel           = getenv('VLLM_VISION_MODEL');
        $embeddingModel        = getenv('HF_EMBEDDING_MODEL');

        // Validate that all required environment variables are set
        $this->assertNotEmpty(
            $chatInferenceUrl,
            'VLLM_CHAT_API_URL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $visionInferenceUrl,
            'VLLM_VISION_API_URL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $apiKey,
            'VLLM_API_KEY is not set in the environment.'
        );
        $this->assertNotEmpty(
            $chatModel,
            'VLLM_CHAT_MODEL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $visionModel,
            'VLLM_VISION_MODEL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $embeddingInferenceUrl,
            'VLLM_EMBEDDING_API_URL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $embeddingModel,
            'VLLM_EMBEDDING_MODEL is not set in the environment.'
        );

        // Assign model names to class properties
        $this->model          = $chatModel;
        $this->visionModel    = $visionModel;
        $this->embeddingModel = $embeddingModel;

        // Initialize Vllm clients with respective URLs and shared API key
        $this->client = new VllmClient(
            apiKey: (string)$apiKey,
            url   : $chatInferenceUrl
        );

        $this->visionClient = new VllmClient(
            apiKey: (string)$apiKey,
            url   : $visionInferenceUrl
        );

        $this->embeddingClient = new VllmClient(
            apiKey: (string)$apiKey,
            url   : $embeddingInferenceUrl
        );

        // Configure logger for all clients
        $this->client->setLogger(LoggerFactory::create());
        $this->visionClient->setLogger(LoggerFactory::create());
        $this->embeddingClient->setLogger(LoggerFactory::create());
    }
}