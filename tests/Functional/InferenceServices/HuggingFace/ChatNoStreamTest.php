<?php

namespace Tests\Functional\InferenceServices\HuggingFace;

use Throwable;

/**
 * Class ChatNoStreamTest
 *
 * This class contains functional tests for the HuggingFace client
 * in non-streaming mode while ensuring proper responses and behavior.
 */
class ChatNoStreamTest extends Setup
{
    /**
     * Test Chat API with non-streaming mode and `max_tokens` set to 1024
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens1024(): void
    {
        // Prepare a test request with a user-provided message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Parameters configuration for the chat request
        $params = [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 512,
            'seed' => 15,
            'model' => $this->model
        ];

        try {
            // Send a chat request in non-streaming mode
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Validate the successful response
            $this->assertNotNull($response, 'The response should not be null.');

            $message = $response->getMessage();
            $this->assertEquals(
                'stop',
                $response->getStopReason(),
                'The stop reason should be "stop" for max_tokens = 1024.'
            );

            // Ensure the response message is a non-empty string
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Verify the message contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');

            // Output the result to the console for debugging purposes
            $this->consoleInfo($message);
        } catch (Throwable $e) {
            // Fail the test if the request throws an exception
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test Chat API with non-streaming mode and `max_tokens` set to 50
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens50(): void
    {
        // Prepare a test request with a user-provided message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Parameters configuration for the chat request
        $params = [
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 150, // Adjusted tokens for this test
            'seed' => 15,
            'model' => $this->model
        ];

        try {
            // Send a chat request in non-streaming mode
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Validate the successful response
            $this->assertNotNull($response, 'The response should not be null.');

            $message = $response->getMessage();
            $this->assertEquals(
                'length',
                $response->getStopReason(),
                'The stop reason should be "length" for max_tokens = 50.'
            );

            // Ensure the response message is a non-empty string
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Verify the message contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');

            // Output the result to the console for debugging purposes
            $this->consoleInfo($message);
        } catch (Throwable $e) {
            // Fail the test if the request throws an exception
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}