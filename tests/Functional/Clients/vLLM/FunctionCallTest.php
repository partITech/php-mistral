<?php

namespace Tests\Functional\Clients\vLLM;

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\Parameter;
use Partitech\PhpMistral\Tools\Tool;

/**
 * Class FunctionCallTest
 *
 * Functional test to verify that a function call is correctly performed
 * with the configured tool and expected parameters.
 */
class FunctionCallTest extends Setup
{
    /**
     * Test to ensure that a function call is present in the client's response and validated.
     *
     * @return void
     */
    public function testFunctionCallIsPresent(): void
    {
        // Configure a simple tool to simulate a function call
        $transactionIdParam = new Parameter(
            type: Parameter::STRING_TYPE,
            name: 'transactionId',
            description: 'The transaction ID.',
            required: true
        );

        // Define the function tool with its parameters and description
        $retrievePaymentStatusFunction = new FunctionTool(
            name: 'retrievePaymentStatus',
            description: 'Get payment status of a transaction ID',
            parameters: [$transactionIdParam]
        );

        // Initialize an array of tools including the function tool
        $tools = [
            new Tool('function', $retrievePaymentStatusFunction)
        ];

        // Simulate a user message requesting transaction status
        $messages = $this->client->getMessages()
            ->addUserMessage("My transaction id is PHP13 What is the status of my transaction?");

        try {
            // Send the message along with the configured tools and other parameters
            $chatResponse = $this->client->chat(
                messages: $messages,
                params: [
                    'temperature' => 0.1, // Set response creativity/variation
                    'model' => $this->model, // Model configuration for processing
                    'tools' => $tools, // Attach the tools
                    'tool_choice' => Client::TOOL_CHOICE_AUTO // Allow automatic tool selection
                ]
            );
        } catch (\Throwable $e) {
            // Fail the test if an exception occurs during the chat
            $this->fail('Function call test failed with error: ' . $e->getMessage());
        }

        // Retrieve tool calls to verify they are present in the response
        $toolCalls = $chatResponse->getToolCalls();

        // Optionally log tool calls for debugging or verification
        $this->consoleNote($toolCalls);

        // Validate that at least one tool call exists in the response
        $this->assertNotEmpty($toolCalls, 'There should be at least one tool call in the response.');
        $this->assertIsArray($toolCalls, 'The tool calls should be an array.');

        // Verify the details of the first tool call
        $toolCall = $toolCalls[0];
        
        // Ensure the "function" key exists in the tool call
        $this->assertArrayHasKey('function', $toolCall, 'The tool call should include a "function" key.');

        // Ensure the "name" key exists within the "function"
        $this->assertArrayHasKey('name', $toolCall['function'], 'The "function" key should include a "name".');

        // Verify the function call matches the expected function
        $this->assertEquals(
            'retrievePaymentStatus',
            $toolCall['function']['name'],
            'The called function name should match.'
        );

        // Verify the arguments passed to the function
        $this->assertArrayHasKey('arguments', $toolCall['function'], 'The "function" key should include "arguments".');
        $arguments = $toolCall['function']['arguments'];

        // Ensure the "transactionId" parameter exists in the arguments
        $this->assertArrayHasKey('transactionId', $arguments, 'The function arguments should include a "transactionId".');
    }
}