<?php

namespace Tests\Functional\InferenceServices\Mistral;

use Throwable;

class ChatNoStreamTest extends Setup
{
    /**
     * Test method to verify chat functionality with max_tokens set to 1024 in non-stream mode.
     * Asserts that the response is valid, the stop reason is 'stop', and the message contains multiple words.
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens1024(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

        // Define parameters for the chat request
        $params = [
            'temperature' => 0.7,  // Define randomness in the response
            'top_p' => 1,        // Sampling parameter ensuring broad token usage
            'max_tokens' => 1024, // Maximum number of tokens in the response
            'seed' => null,       // Optional seed for consistent results
            'model' => $this->model // Chat model to be used
        ];

        try {
            // Send a chat request in non-stream mode
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Validate the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Get the response message
            $message = $response->getMessage();

            // Assert the stop reason is 'stop' (indicating the token limit was reached)
            $this->assertEquals('stop', $response->getStopReason(), 'The stop reason should be "stop" for max_tokens = 1024.');

            // Ensure the response message is a valid, non-empty string
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Verify the response message contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');
        } catch (Throwable $e) {
            // Handle and fail the test if any exception occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test method to verify chat functionality with max_tokens set to 150 in non-stream mode.
     * Asserts that the response is valid, the stop reason is 'length', and the message contains multiple words.
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens50(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

        // Define parameters for the chat request
        $params = [
            'temperature' => 0.7,  // Define randomness in the response
            'top_p' => 1,        // Sampling parameter ensuring broad token usage
            'max_tokens' => 150,  // Maximum number of tokens in the response
            'seed' => 15,         // Optional seed for consistent results
            'model' => $this->model // Chat model to be used
        ];

        try {
            // Send a chat request in non-stream mode
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Validate the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Get the response message
            $message = $response->getMessage();

            // Assert the stop reason is 'length' (indicating token limit was reached)
            $this->assertEquals('length', $response->getStopReason(), 'The stop reason should be "length" for max_tokens = 150.');

            // Ensure the response message is a valid, non-empty string
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Verify the response message contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');
        } catch (Throwable $e) {
            // Handle and fail the test if any exception occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}