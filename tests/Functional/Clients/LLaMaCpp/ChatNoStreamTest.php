<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Functional tests for the Chat API in non-stream mode with varying max_tokens limits.
 */
class ChatNoStreamTest extends Setup
{
    /**
     * Tests the chat functionality with a limit of 1024 max tokens in non-stream mode.
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens1024(): void
    {
        // Prepare a test request with a predefined user message.
        $messages = $this->client
            ->getMessages()
            ->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

        // Configuration parameters for the chat request.
        $params = [
            'temperature' => 0.7, // Controls randomness in the response.
            'top_p'       => 1,   // Probability mass considered (1 = all tokens).
            'max_tokens'  => 1024, // Maximum tokens to generate.
            'seed'        => 15,  // Set the random seed for reproducibility.
        ];

        try {
            // Send a non-streaming chat request to the API.
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Assert that the API response is not null.
            $this->assertNotNull($response, 'The response should not be null.');

            // Get the message content from the response.
            $message = $response->getMessage();

            // Assert the stop reason is "stop" because max_tokens = 1024.
            $this->assertEquals(
                'stop',
                $response->getStopReason(),
                'The stop reason should be "stop" for max_tokens = 1024.'
            );

            // Validate the response message.
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Ensure the response message contains multiple words.
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');

        } catch (Throwable $e) {
            // Fail the test if an exception is thrown.
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Tests the chat functionality with a limit of 150 max tokens in non-stream mode.
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens50(): void
    {
        // Prepare a test request with a predefined user message.
        $messages = $this->client
            ->getMessages()
            ->addUserMessage('What are the ingredients that make up dijon mayonnaise?');

        // Configuration parameters for the chat request.
        $params = [
            'temperature' => 0.7, // Controls randomness in the response.
            'top_p'       => 1,   // Probability mass considered (1 = all tokens).
            'max_tokens'  => 150, // Maximum tokens to generate. (Corrected value: Original test references max 50.)
            'seed'        => 15,  // Set the random seed for reproducibility.
        ];

        try {
            // Send a non-streaming chat request to the API.
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Assert that the API response is not null.
            $this->assertNotNull($response, 'The response should not be null.');

            // Get the message content from the response.
            $message = $response->getMessage();

            // Assert the stop reason is "length" indicating a token limit was reached.
            $this->assertEquals(
                'length',
                $response->getStopReason(),
                'The stop reason should be "length" when max_tokens = 150.'
            );

            // Validate the response message.
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Ensure the response message contains multiple words.
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');

        } catch (Throwable $e) {
            // Fail the test if an exception is thrown.
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}