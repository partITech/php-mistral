<?php

namespace Tests\Functional\Clients\vLLM;

use Throwable;

/**
 * @covers ChatNoStreamTest
 * This class contains functional test cases for testing chat functionality in non-streaming mode.
 */
class ChatNoStreamTest extends Setup
{
    /**
     * Test chat functionality with a maximum token limit of 1024 in non-streaming mode.
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens1024(): void
    {
        // Create a message from the user
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Set request parameters for the test
        $params = [
            'temperature' => 0.7,
            'top_p'       => 1,
            'max_tokens'  => 512,
            'seed'        => 15,
            'model'       => $this->model
        ];

        try {
            // Send a non-streamed chat request
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Ensure the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract the message from the response
            $message = $response->getMessage();

            // Verify the stop reason is "stop" for the given token limit
            $this->assertEquals(
                'stop',
                $response->getStopReason(),
                'The stop reason should be "stop" for max_tokens = 1024.'
            );

            // Validate the response message is a non-empty string
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Ensure the response contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');

            // Log the response to the console
            $this->consoleInfo($message);
        } catch (Throwable $e) {
            // Mark the test as a failure if an exception is thrown
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test chat functionality with a maximum token limit of 50 in non-streaming mode.
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens50(): void
    {
        // Create a message from the user
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Set request parameters for the test
        $params = [
            'temperature' => 0.7,
            'top_p'       => 1,
            'max_tokens'  => 150,
            'seed'        => 15,
            'model'       => $this->model
        ];

        try {
            // Send a non-streamed chat request
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Ensure the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Extract the message from the response
            $message = $response->getMessage();

            // Verify the stop reason is "length" for the given token limit
            $this->assertEquals(
                'length',
                $response->getStopReason(),
                'The stop reason should be "length" for max_tokens = 50.'
            );

            // Validate the response message is a non-empty string
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Ensure the response contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');

            // Log the response to the console
            $this->consoleInfo($message);
        } catch (Throwable $e) {
            // Mark the test as a failure if an exception is thrown
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}