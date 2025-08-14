<?php

namespace Tests\Functional\Clients\Tgi;

use Partitech\PhpMistral\Exceptions\MistralClientException;

/**
 * Functional tests for the chat functionality without streaming.
 */
class ChatNoStreamTest extends Setup
{
    /**
     * Test the chat response with a maximum of 1024 tokens.
     *
     * This test sends a user message and validates the response when the 
     * maximum token count is set to 1024. It ensures the response meets 
     * expectations such as non-nullity, valid message structure, and word count.
     */
    public function testChatNoStreamMaxTokens1024(): void
    {
        // Prepare a test request with user input
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Parameters for the chat request
        $params = [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 1024,
            'seed' => null,
        ];

        try {
            // Send a chat request in non-stream mode
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Assert that the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract the message content from the response
            $message = $response->getMessage();

            // Assert that the stop reason is "stop" because max_tokens is 1024
            $this->assertEquals(
                'stop', 
                $response->getStopReason(), 
                'The stop reason should be "stop" for max_tokens = 1024.'
            );

            // Ensure the returned message is valid
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Check that the response contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');
        } catch (\Throwable $e) {
            // Handle exceptions and mark the test as failed if an error occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test the chat response with a maximum of 50 tokens.
     *
     * This test sends a user message and validates the response when the 
     * maximum token count is set to 50. It ensures the response meets 
     * expectations such as non-nullity, valid message structure, and word count.
     */
    public function testChatNoStreamMaxTokens50(): void
    {
        // Prepare a test request with user input
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Parameters for the chat request
        $params = [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 150, // Sets maximum length for the response
            'seed' => 15,        // Explicit seed value for reproducibility
            'model' => $this->model
        ];

        try {
            // Send a chat request in non-stream mode
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Assert that the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract the message content from the response
            $message = $response->getMessage();

            // Assert that the stop reason is "length" for responses limited by tokens
            $this->assertEquals(
                'length', 
                $response->getStopReason(), 
                'The stop reason should be "length" for max_tokens = 50.'
            );

            // Ensure the returned message is valid
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Check that the response contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');
        } catch (\Throwable $e) {
            // Handle exceptions and mark the test as failed if an error occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}