<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Exceptions\MistralClientException;

/**
 * Test class for Chat (no stream mode) functionality
 */
class ChatNoStreamTest extends Setup
{
    /**
     * Test the chat functionality in no-stream mode with a max token limit of 1024
     *
     * @return void
     * @throws MistralClientException
     */
    public function testChatNoStreamMaxTokens1024(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Configuration parameters for the chat request
        $params = [
            'temperature' => 0.7, // Balances creativity and randomness
            'top_p'       => 1, // Probability mass for nucleus sampling
            'max_tokens'  => 1024, // Limits the response length
            'seed'        => null, // Optional seed for reproducibility
            'model'       => $this->model // Specifies the model to use
        ];

        try {
            // Send the chat request (non-stream mode)
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Ensure that the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Verify stop reason for the response
            $message = $response->getMessage();
            $this->assertEquals(
                'stop',
                $response->getStopReason(),
                'The stop reason should be "stop" for max_tokens = 1024.'
            );

            // Ensure that the message is a valid non-empty string
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Check that the response contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');
        } catch (MistralClientException $e) {
            // If the request fails, report it with an error
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test the chat functionality in no-stream mode with a max token limit of 50
     *
     * @return void
     * @throws MistralClientException
     */
    public function testChatNoStreamMaxTokens50(): void
    {
        // Prepare a test request with a user message
        $messages = $this->client->getMessages()->addUserMessage(
            'What are the ingredients that make up dijon mayonnaise?'
        );

        // Configuration parameters for the chat request
        $params = [
            'temperature' => 0.7, // Balances creativity and randomness
            'top_p'       => 1, // Probability mass for nucleus sampling
            'max_tokens'  => 150, // Limits the response length
            'seed'        => 15, // Optional seed for reproducibility
            'model'       => $this->model // Specifies the model to use
        ];

        try {
            // Send the chat request (non-stream mode)
            $response = $this->client->chat(messages: $messages, params: $params, stream: false);

            // Ensure that the response is not null
            $this->assertNotNull($response, 'The response should not be null.');

            // Verify stop reason for the response
            $message = $response->getMessage();
            $this->assertEquals(
                'length',
                $response->getStopReason(),
                'The stop reason should be "length" for max_tokens = 50.'
            );

            // Ensure that the message is a valid non-empty string
            $this->assertIsString($message, 'The response message should be a string.');
            $this->assertNotEmpty($message, 'The response message should not be empty.');

            // Check that the response contains multiple words
            $wordCount = str_word_count($message);
            $this->assertGreaterThan(1, $wordCount, 'The response message should contain multiple words.');
        } catch (MistralClientException $e) {
            // If the request fails, report it with an error
            $this->fail('Request failed with error: ' . $e->getMessage());
        }
    }
}