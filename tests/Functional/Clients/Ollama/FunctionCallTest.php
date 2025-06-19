<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\Parameter;
use Partitech\PhpMistral\Tools\Tool;

/**
 * Class FunctionCallTest
 * 
 * Test suite for verifying the presence and validity of function calls using the tool configuration.
 */
class FunctionCallTest extends Setup
{
    /**
     * Test to verify if a function call is present and properly configured in the response.
     * 
     * @return void
     */
    public function testFunctionCallIsPresent(): void
    {
        // Set up a parameter for the tool: transactionId (required string)
        $transactionIdParam = new Parameter(
            type: Parameter::STRING_TYPE,
            name: 'transactionId',
            description: 'The transaction ID.',
            required: true
        );

        // Configure a function tool for retrieving the payment status
        $retrievePaymentStatusFunction = new FunctionTool(
            name: 'retrievePaymentStatus',
            description: 'Get payment status of a transaction ID',
            parameters: [$transactionIdParam]
        );

        // Wrap the function tool in a generic Tool object
        $tools = [
            new Tool('function', $retrievePaymentStatusFunction)
        ];

        // Build the user message
        $messages = $this->client->getMessages()
                                 ->addUserMessage("My transaction id is PHP13. What is the status of my transaction?");

        try {
            // Send a chat request using the configured tools and model parameters
            $chatResponse = $this->client->chat(
                messages: $messages,
                params: [
                    'temperature' => 0.1, // Lower temperature for deterministic behavior
                    'model' => $this->model,
                    'tools' => $tools,
                    'tool_choice' => Client::TOOL_CHOICE_AUTO // Automatically select the tool
                ]
            );

            // Retrieve tool calls from the chat response
            $toolCalls = $chatResponse->getToolCalls();

            // Assert that there is at least one tool call in the response
            $this->assertNotEmpty($toolCalls, 'There should be at least one tool call in the response.');
            $this->assertIsArray($toolCalls, 'The tool calls should be an array.');

            // Check details of the first tool call
            $toolCall = $toolCalls[0];

            // Assert the presence of a function in the tool call
            $this->assertArrayHasKey('function', $toolCall, 'The tool call should include a "function" key.');

            // Verify the name of the called function
            $this->assertArrayHasKey('name', $toolCall['function'], 'The "function" key should include a "name".');
            $this->assertEquals('retrievePaymentStatus', $toolCall['function']['name'], 'The called function name should match.');

            // Verify the arguments passed to the function
            $this->assertArrayHasKey('arguments', $toolCall['function'], 'The "function" key should include "arguments".');
            $arguments = $toolCall['function']['arguments'];
            $this->assertArrayHasKey('transactionId', $arguments, 'The function arguments should include a "transactionId".');
        } catch (MistralClientException $e) {
            // Fail the test if a custom exception is thrown
            $this->fail('Function call test failed with error: ' . $e->getMessage());
        }
    }
}