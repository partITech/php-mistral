<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\Parameter;
use Partitech\PhpMistral\Tools\Tool;

/**
 * Functional test case for the FunctionCall functionality.
 * This test ensures that a configured function call is properly executed
 * and validated in the client's chat response.
 */
class FunctionCallTest extends Setup
{
    /**
     * Test that a function call is present in the chat response and properly formatted.
     *
     * @return void
     */
    public function testFunctionCallIsPresent(): void
    {
        // Define a required parameter `transactionId` for the function to simulate real usage
        $transactionIdParam = new Parameter(
            type: Parameter::STRING_TYPE,
            name: 'transactionId',
            description: 'The transaction ID.',
            required: true // Mark this parameter as mandatory
        );

        // Define a function tool `retrievePaymentStatus` to get the payment status of a transaction
        $retrievePaymentStatusFunction = new FunctionTool(
            name: 'retrievePaymentStatus',
            description: 'Get payment status of a transaction ID',
            parameters: [$transactionIdParam] // Bind the previously defined parameter
        );

        // Wrap the function tool inside a tool object (required by the client)
        $tools = [
            new Tool('function', $retrievePaymentStatusFunction)
        ];

        // Simulate a user asking for the status of a transaction
        $messages = $this->client
            ->getMessages()
            ->addUserMessage("My transaction id is PHP13. What is the status of my transaction?");

        try {
            // Send the chat request with configured parameters and tools
            $chatResponse = $this->client->chat(
                messages: $messages,
                params: [
                    'temperature' => 0.1, // Set response randomness; lower means more deterministic
                    'tools' => $tools, // Provide the defined tools to the client
                    'tool_choice' => Client::TOOL_CHOICE_AUTO // Let the client choose appropriate tools automatically
                ]
            );

            // Retrieve tool calls from the chat response
            $toolCalls = $chatResponse->getToolCalls();

            // Assert that at least one tool call has been made
            $this->assertNotEmpty($toolCalls, 'There should be at least one tool call in the response.');
            $this->assertIsArray($toolCalls, 'The tool calls should be an array.');

            // Validate the details of the first tool call
            $toolCall = $toolCalls[0]; // Take the first tool call for validation
            $this->assertArrayHasKey('function', $toolCall, 'The tool call should include a "function" key.');
            $this->assertArrayHasKey('name', $toolCall['function'], 'The "function" key should include a "name".');
            $this->assertEquals(
                'retrievePaymentStatus',
                $toolCall['function']['name'],
                'The called function name should match the expected "retrievePaymentStatus".'
            );

            // Validate the arguments passed to the function
            $this->assertArrayHasKey('arguments', $toolCall['function'], 'The "function" key should include "arguments".');
            $arguments = $toolCall['function']['arguments'];
            $this->assertArrayHasKey('transactionId', $arguments, 'The function arguments should include a "transactionId".');

        } catch (MistralClientException $e) {
            // Fail the test if an exception from the client occurs
            $this->fail('Function call test failed with error: ' . $e->getMessage());
        }
    }
}