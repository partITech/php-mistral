<?php

namespace Tests\Functional\Clients\Tgi;

use Throwable;

/**
 * Class ChatStreamTest
 * Provides functional tests for the chat streaming feature of the TGI client.
 */
class ChatStreamTest extends Setup
{
    /**
     * Tests if chat stream responses for max_tokens=50 are valid and follow expected rules.
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens50(): void
    {
        // Step 1: Prepare input messages and parameters for the chat request
        $messages = $this->client->getMessages()
            ->addUserMessage('What are the ingredients that make up dijon mayonnaise?');
        
        $params = [
            'temperature' => 0.7, // Controls the variability of the output
            'top_p' => 1,        // Probability threshold for nucleus sampling
            'max_tokens' => 50,  // Maximum number of tokens in the response
            'seed' => 15,        // Seed for deterministic results
            'model' => $this->model // Model to be used for the request
        ];

        $responseChunks = []; // Stores the chunks that are streamed from the API
        
        try {
            // Step 2: Send the chat request and retrieve response chunks in stream mode
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk(); // Store each response chunk
            }

            // Step 3: Verify the integrity of the response
            // Verify that multiple chunks are returned
            $this->assertGreaterThan(1, count($responseChunks), 
                'The response should contain multiple chunks.');

            $fullResponse = implode(' ', $responseChunks); // Combine all chunks into one response
            $wordCount = str_word_count($fullResponse);    // Calculate the number of words in the full response
            
            // Check if the concatenated response is not empty and has multiple words
            $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
            $this->assertGreaterThan(1, $wordCount, 
                'The full response should contain multiple words.');

            // Check if the stop reason is 'length' for max_tokens = 50
            $this->assertEquals('length', $chunk->getStopReason(), 
                'The stop reason should be "length" for max_tokens = 50.');

            // Log the full response to the console
            $this->consoleInfo($fullResponse);
        } catch (Throwable $e) {
            // Handle any errors that occur during the request
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Tests if chat stream responses for max_tokens=1024 are valid and follow expected rules.
     *
     * @return void
     */
    public function testChatStreamResponseMaxTokens1024(): void
    {
        // Step 1: Prepare input messages and parameters for the chat request
        $messages = $this->client->getMessages()
            ->addUserMessage('In one word, what is the main ingredient that makes up dijon mayonnaise?');
        
        $params = [
            'temperature' => 0.1,    // Controls response randomness (lower value = more deterministic)
            'top_p' => 1,           // Probability threshold for nucleus sampling
            'max_tokens' => 4024,   // Maximum tokens in the response
            'seed' => 15,           // Seed for deterministic results
            'model' => $this->model // Model to be used for the request
        ];

        $responseChunks = []; // Stores the streamed response chunks
        $stopReason = null;   // Stores the reason for stopping the streaming

        try {
            // Step 2: Send the chat request and retrieve response chunks in stream mode
            foreach ($this->client->chat(messages: $messages, params: $params, stream: true) as $chunk) {
                $responseChunks[] = $chunk->getChunk(); // Store each response chunk
            }
        } catch (Throwable $e) {
            // Handle any errors that occur during the request
            $this->fail('Request failed with error: ' . $e->getMessage());
        }

        // Step 3: Verify the integrity of the response
        // Verify that at least one chunk is returned
        $this->assertGreaterThan(0, count($responseChunks), 
            'The response should contain multiple chunks.');

        $fullResponse = implode(' ', $responseChunks); // Combine all chunks into one response
        $wordCount = str_word_count($fullResponse);    // Calculate the number of words in the full response

        // Check if the response is not empty and contains words
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        $this->assertGreaterThan(0, $wordCount, 
            'The full response should contain at least one word.');

        // Check if the stop reason is 'stop' for max_tokens = 1024
        $this->assertEquals('stop', $chunk->getStopReason(), 
            'The stop reason should be "stop" for max_tokens = 1024.');

        // Log the full response to the console
        $this->consoleInfo($fullResponse);
    }
}