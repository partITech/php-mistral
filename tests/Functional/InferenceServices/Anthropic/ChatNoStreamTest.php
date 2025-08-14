<?php

namespace Tests\Functional\InferenceServices\Anthropic;

class ChatNoStreamTest extends Setup
{
    /**
     * Test chat request with a maximum of 1024 tokens.
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens1024(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Define parameters for the chat request
        $params = [
            'temperature' => 0.7,
            'top_p'       => 1,
            'max_tokens'  => 1024,
            'seed'        => 15,
            'model'       => $this->model,
        ];

        try {
            // Send a chat request in non-streaming mode
            $response = $this->client->chat(
                messages: $messages,
                params: $params,
                stream: false
            );

            // Ensure the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Retrieve the message from the response
            $message = $response->getMessage();

            // Validate the stop reason
            $this->assertContains(
                $response->getStopReason(),
                ['stop', 'end_turn'],
                'The stop reason should be either "stop" or "end_turn".'
            );

            // Ensure the response message is valid
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Check that the message contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(
                1,
                $wordCount,
                'The response message should contain multiple words.'
            );

            // Log the message to the console
            $this->consoleInfo($message);
        } catch (\Throwable $e) {
            // Fail the test if an exception occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test chat request with a maximum of 50 tokens.
     *
     * @return void
     */
    public function testChatNoStreamMaxTokens50(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Define parameters for the chat request
        $params = [
            'temperature' => 0.7,
            'top_p'       => 1,
            'max_tokens'  => 50,
            'seed'        => 15,
            'model'       => $this->model,
        ];

        try {
            // Send a chat request in non-streaming mode
            $response = $this->client->chat(
                messages: $messages,
                params: $params,
                stream: false
            );

            // Ensure the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Retrieve the message from the response
            $message = $response->getMessage();

            // Validate the stop reason
            $this->assertEquals(
                'length',
                $response->getStopReason(),
                'The stop reason should be "length" for max_tokens=50.'
            );

            // Ensure the response message is valid
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Check that the message contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(
                1,
                $wordCount,
                'The response message should contain multiple words.'
            );

            // Log the message to the console
            $this->consoleInfo($message);
        } catch (\Throwable $e) {
            // Fail the test if an exception occurs
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}