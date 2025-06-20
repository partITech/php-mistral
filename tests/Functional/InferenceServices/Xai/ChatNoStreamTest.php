<?php

namespace Tests\Functional\InferenceServices\Xai;

class ChatNoStreamTest extends Setup
{
    /**
     * Test chat functionality with max_tokens set to 1024 (non-stream mode).
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens1024(): void
    {
        // Prepare the test message
        $messages = $this->client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

        // Define the chat parameters
        $params = [
            'temperature' => 0.7, // Controls the randomness of the output
            'top_p' => 1,        // Controls nucleus sampling (1 = no restriction)
            'max_tokens' => 1024, // Maximum tokens for the response
            'seed' => null,       // Random seed (null = no fixed seed)
            'model' => $this->model // Model to use for the chat
        ];

        try {
            // Send a chat request in non-streaming mode
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Validate the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Retrieve the response message
            $message = $response->getMessage();

            // Check if the stop reason is "stop"
            $this->assertEquals('stop', $response->getStopReason(), 'The stop reason should be "stop" for max_tokens = 1024.');

            // Ensure the response message is a string and is not empty
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Validate that the response contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');
        } catch (\Throwable $e) {
            // Fail the test if any exception occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test chat functionality with max_tokens set to 150 and seed set to 15 (non-stream mode).
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens50(): void
    {
        // Prepare the test message
        $messages = $this->client->getMessages()->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

        // Define the chat parameters
        $params = [
            'temperature' => 0.7, // Controls the randomness of the output
            'top_p' => 1,        // Controls nucleus sampling (1 = no restriction)
            'max_tokens' => 150,  // Maximum tokens for the response
            'seed' => 15,         // Random seed for reproducibility
            'model' => $this->model // Model to use for the chat
        ];

        try {
            // Send a chat request in non-streaming mode
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Validate the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Retrieve the response message
            $message = $response->getMessage();

            // Check if the stop reason is "length"
            $this->assertEquals('length', $response->getStopReason(), 'The stop reason should be "length" for max_tokens = 150.');

            // Ensure the response message is a string and is not empty
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Validate that the response contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');
        } catch (\Throwable $e) {
            // Fail the test if any exception occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}