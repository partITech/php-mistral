<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Class ChatStreamTest
 * 
 * Tests the streaming chat response functionality of the LlamaCppClient.
 */
class ChatStreamTest extends Setup
{
    /**
     * Test behavior of the chat stream response with a max token limit of 50.
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens50(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');
        
        // Define chat parameters
        $params = [
            'temperature' => 0.7, // Sampling temperature to control randomness
            'top_p' => 1,         // Probability mass for nucleus sampling
            'max_tokens' => 50,   // Maximum number of tokens for the response
            'seed' => null,       // Optional seed for determinism
        ];

        $responseChunks = []; // Initialize response chunks array

        try {
            // Stream chat response in chunks
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk(); // Extract and store each response chunk
            }

            // Assert that the response contains multiple chunks
            $this->assertGreaterThan(1, count($responseChunks), 'The response should contain multiple chunks.');

            // Concatenate all response chunks into one string for further analysis
            $fullResponse = implode(' ', $responseChunks);
            $wordCount = str_word_count($fullResponse); // Calculate the word count

            // Assert that the full response is not empty
            $this->assertNotEmpty($fullResponse, 'The full response text is empty.');

            // Assert that the response contains multiple words
            $this->assertGreaterThan(1, $wordCount, 'The full response should contain multiple words.');

            // Confirm that the stop reason is due to reaching the 'max_tokens' limit
            $this->assertEquals('length', $chunk->getStopReason(), 'The stop reason should be "length" for max_tokens = 50.');
        } catch (Throwable $e) {
            // Fail the test if any exception is raised
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test behavior of the chat stream response with a max token limit of 1024.
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens1024(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');
        
        // Define chat parameters
        $params = [
            'temperature' => 0.7, // Sampling temperature to control randomness
            'top_p' => 1,         // Probability mass for nucleus sampling
            'max_tokens' => 1024, // Maximum number of tokens for the response
            'seed' => null,       // Optional seed for determinism
        ];

        $responseChunks = []; // Initialize response chunks array
        $stopReason = null;   // Initialize stop reason

        try {
            // Stream chat response in chunks
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk(); // Extract and store each response chunk
                $stopReason = $chunk->getStopReason();  // Extract stop reason from each chunk
            }

            // Assert that the response contains multiple chunks
            $this->assertGreaterThan(1, count($responseChunks), 'The response should contain multiple chunks.');

            // Concatenate all response chunks into one string for further analysis
            $fullResponse = implode(' ', $responseChunks);
            $wordCount = str_word_count($fullResponse); // Calculate the word count

            // Assert that the full response is not empty
            $this->assertNotEmpty($fullResponse, 'The full response text is empty.');

            // Assert that the response contains multiple words
            $this->assertGreaterThan(1, $wordCount, 'The full response should contain multiple words.');

            // Confirm that the stop reason is 'stop'
            $this->assertEquals('stop', $stopReason, 'The stop reason should be "stop" for max_tokens = 1024.');
        } catch (Throwable $e) {
            // Fail the test if any exception is raised
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}