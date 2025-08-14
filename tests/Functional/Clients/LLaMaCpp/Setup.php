<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;
use Partitech\PhpMistral\Log\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Tests\Traits\TestCleanupTrait;
use Tests\Traits\TestConsoleOutputTrait;

/**
 * Class Setup
 *
 * A functional test setup for initializing the LlamaCppClient instances
 * with various configurations (chat, embedding, FIM, rerank APIs).
 * This class validates environment variables and sets up the clients for testing.
 */
class Setup extends TestCase
{
    use TestConsoleOutputTrait, TestCleanupTrait;

    /**
     * LlamaCppClient for chat inference.
     *
     * @var LlamaCppClient
     */
    protected LlamaCppClient $client;

    /**
     * LlamaCppClient for embedding inference.
     *
     * @var LlamaCppClient
     */
    protected LlamaCppClient $embeddingClient;

    /**
     * LlamaCppClient for FIM (Fill-in-the-Middle) inference.
     *
     * @var LlamaCppClient
     */
    protected LlamaCppClient $fimInferenceClient;

    /**
     * LlamaCppClient for rerank inference.
     *
     * @var LlamaCppClient
     */
    protected LlamaCppClient $rerankInferenceClient;

    /**
     * Prepares the test environment by validating required environment variables and
     * initializing LlamaCppClient instances for the various API endpoints.
     *
     * @return void
     */
    protected function setUp(): void
    {
        // Retrieve environment variables
        $chatInferenceUrl      = getenv('LLAMACPP_CHAT_URL');
        $embeddingInferenceUrl = getenv('LLAMACPP_EMBEDDING_URL');
        $fimInferenceUrl       = getenv('LLAMACPP_FIM_URL');
        $rerankInferenceUrl    = getenv('LLAMACPP_RERANK_URL');
        $apiKey                = getenv('API_KEY');

        // Validate that required environment variables are present
        $this->assertNotEmpty(
            $chatInferenceUrl,
            'LLAMACPP_CHAT_URL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $embeddingInferenceUrl,
            'LLAMACPP_EMBEDDING_URL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $fimInferenceUrl,
            'LLAMACPP_FIM_URL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $rerankInferenceUrl,
            'LLAMACPP_RERANK_URL is not set in the environment.'
        );
        $this->assertNotEmpty(
            $apiKey,
            'API_KEY is not set in the environment.'
        );

        // Initialize the LlamaCppClient for chat inference
        $this->client = new LlamaCppClient(
            apiKey: (string) $apiKey,
            url: $chatInferenceUrl
        );

        // Initialize the LlamaCppClient for embedding inference
        $this->embeddingClient = new LlamaCppClient(
            apiKey: (string) $apiKey,
            url: $embeddingInferenceUrl
        );

        // Initialize the LlamaCppClient for FIM inference
        $this->fimInferenceClient = new LlamaCppClient(
            apiKey: (string) $apiKey,
            url: $fimInferenceUrl
        );

        // Initialize the LlamaCppClient for rerank inference
        $this->rerankInferenceClient = new LlamaCppClient(
            apiKey: (string) $apiKey,
            url: $rerankInferenceUrl
        );

        // Set the logger for the main client to track logs
        $this->client->setLogger(LoggerFactory::create());
    }
}