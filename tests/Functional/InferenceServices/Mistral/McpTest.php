<?php

namespace Tests\Functional\InferenceServices\Mistral;

use Exception;
use Mcp\Types\GetPromptResult;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Mcp\McpConfig;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Resource;
use Tests\Traits\McpTrait;

/**
 * Class McpTest
 * Functional tests for MCP (Mistral Command Process) services.
 */
class McpTest extends Setup
{
    use McpTrait;

    /**
     * Tests the MCP chat streaming functionality and verifies responses and the existence of expected output files.
     *
     * @throws Exception
     */
    public function testMcpStream(): void
    {
        // Clean up any temporary or variable files used during testing.
        $this->cleanupVar();

        // Set the maximum recursion allowed for the MCP client.
        $this->client->setMcpMaxRecursion(max: 7);

        try {
            /** @var Response[] $responseChunks */
            $responseChunks = [];

            // Stream chat messages and collect response chunks.
            foreach ($this->client->chatStream(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            ) as $chunk) {
                $responseChunks[] = $chunk->getChunk();
            }
        } catch (\Throwable $e) {
            // Log the error message to the console and terminate the script.
            $this->consoleError($e->getMessage());
            exit(1);
        }

        // Combine all response chunks to form the full response.
        $fullResponse = implode('', $responseChunks);
        // Count the number of words in the full response.
        $wordCount = str_word_count((string)$fullResponse);

        // Assert that the full response text is not empty.
        $this->assertNotEmpty($fullResponse, 'The full response text is empty.');
        // Assert that the response contains at least one or more words.
        $this->assertGreaterThan(0, $wordCount, 'The full response should contain multiple words.');
        // Assert that response chunks are in the form of an array.
        $this->assertIsArray($responseChunks);
        // Assert that there is at least one response chunk.
        $this->assertGreaterThan(0, count($responseChunks), 'The response should contain multiple chunks.');

        // Log the full response for debugging purposes.
        $this->consoleInfo($fullResponse);

        // Assert that the `/translated` directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Define the expected files that should be generated.
        $expectedFiles = ['test_en.md']; // English translation file.

        // Verify the existence and validity of each expected file.
        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that each expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");
            // Assert that the file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Tests the MCP chat functionality without streaming and verifies responses and the existence of output files.
     *
     * @throws Exception
     */
    public function testMcpNoStream(): void
    {
        // Clean up any temporary or variable files used during testing.
        $this->cleanupVar();

        // Set the maximum recursion allowed for the MCP client.
        $this->client->setMcpMaxRecursion(max: 10);
        $message = null;

        try {
            // Perform a non-streaming chat operation and retrieve the response.
            $response = $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            );
            // Extract the message content from the response.
            $message = $response->getMessage();
        } catch (\Throwable $e) {
            exit(1); // Exit the script on error.
        }

        // Assert that the response message is not empty.
        $this->assertNotEmpty($message, 'The full response text is empty.');

        // Log the message content for debugging purposes.
        $this->consoleInfo($message);

        // Assert that the `/translated` directory exists.
        $this->assertTrue(is_dir($this->getVarPath() . '/translated'), 'The /translated directory should exist.');

        // Define the expected files that should be generated.
        $expectedFiles = ['test_en.md']; // English translation file.

        // Verify the existence and validity of each expected file.
        foreach ($expectedFiles as $filename) {
            $filePath = $this->getVarPath() . '/translated/' . $filename;

            // Assert that each expected file exists.
            $this->assertTrue(file_exists($filePath), "The file $filename should exist.");
            // Assert that the file is not empty.
            $this->assertGreaterThan(0, filesize($filePath), "The file $filename should not be empty.");
        }
    }

    /**
     * Tests the MCP chat functionality with a forced maximum recursion limit and expects a MaximumRecursionException.
     */
    public function testMcpNoStreamMaxRecursion(): void
    {
        // Clean up any temporary or variable files used during testing.
        $this->cleanupVar();

        // Set the maximum recursion limit to a very low value.
        $this->client->setMcpMaxRecursion(max: 2);

        try {
            // Attempt to perform a non-streaming chat operation, which should fail due to maximum recursion.
            $this->client->chat(
                messages: $this->getMcpMessages($this->client->getMessages()),
                params: $this->getMcpParams($this->model)
            );
        } catch (\Throwable $e) {
            // Assert that the exception thrown is of type MaximumRecursionException.
            self::assertInstanceOf(MaximumRecursionException::class, $e);

            // Log the exception message for debugging purposes.
            $this->consoleInfo($e->getMessage());
        }
    }

    public function testMcpPrompts(): void
    {
        $configJson = file_get_contents(
            realpath('./tests/medias/mcp_config_everything.json')
        );

        // Decoding JSON configuration into an associative array.
        $configArray = json_decode(
            $configJson,
            true
        );

        $mcpConfig = new McpConfig($configArray,[]);
        $promptsList = $mcpConfig->getPromptsList();

        $this->assertNotEmpty($promptsList);
        $this->assertCount(3, $promptsList);
        $this->assertTrue(in_array('simple_prompt', $promptsList));
        $this->assertTrue(in_array('complex_prompt', $promptsList));
        $this->assertTrue(in_array('resource_prompt', $promptsList));

        $simplePrompt = $mcpConfig->getPrompt('simple_prompt');
        $this->assertInstanceOf(Messages::class, $simplePrompt);
        $this->assertEquals('This is a simple prompt without arguments.', $simplePrompt->last()->getContent());

        $complexPrompt = $mcpConfig->getPrompt('complex_prompt', ['temperature' => '1.0', 'style' => 'friendly']);
        $this->assertInstanceOf(Messages::class, $complexPrompt);
        $this->assertCount(3, $complexPrompt->getMessages());
        $this->assertEquals("This is a complex prompt with arguments: temperature=1.0, style=friendly", $complexPrompt->first()->getContent());
        $this->assertEquals("I understand. You've provided a complex prompt with temperature and style arguments. How would you like me to proceed?", $complexPrompt->offset(1)->getContent());
        $this->assertEquals("image_url", $complexPrompt->last()->getContent()[0]['type']);
        $this->assertTrue( str_contains($complexPrompt->last()->getContent()[0]['image_url']['url'], "data:image/png;base64,"));

        $ressourcePrompt = $mcpConfig->getPrompt(promptName: 'resource_prompt', arguments: ['resourceId' =>  '55'], clientType: Client::TYPE_MISTRAL);
        $this->assertInstanceOf(Messages::class, $ressourcePrompt);
        $this->assertCount(1, $ressourcePrompt->getMessages());
        $this->assertEquals("This prompt includes Resource 55. Please analyze the following resource:", $ressourcePrompt->first()->getContent());
        $this->assertNotEmpty($ressourcePrompt->first()->getResource());
        $this->assertInstanceOf(Resource::class, $ressourcePrompt->first()->getResource());
        $this->assertEquals('test://static/resource/55', $ressourcePrompt->first()->getResource()->getUri());
        $this->assertEquals('text/plain', $ressourcePrompt->first()->getResource()->getMimeType());
        $this->assertEquals('Resource 55: This is a plaintext resource', $ressourcePrompt->first()->getResource()->getText());
    }


    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     * @throws Exception
     */
    public function testPhpMistralToolStreaming(): void
    {
        $apiKey = $this->apiKey;
        $model = $this->model;

        $configArray = [
            'mcp' => [
                'servers' => [
                    'test' => [
                        'command' => 'docker',
                        'args' => [
                            'run',
                            '-i',
                            '--rm',
                            'mcp/everything',
                        ],
                    ],
                ],
            ],
        ];
        $mcpConfig = new McpConfig(
            $configArray
        );
        $this->assertIsArray($mcpConfig->getToolsList());
        $this->assertCount(8, $mcpConfig->getToolsList());

        $conversation = (new MistralConversation())
            ->setModel($model)
            ->setName('Conversation')
            ->setDescription('Description')
            ->setTools($mcpConfig);

        $conversationClient = new MistralConversationClient($apiKey);

        $messages = $conversationClient
            ->getMessages()
            ->addAssistantMessage('Do as the user requests')
            ->addUserMessage('Give me a table view of all your available tools');

        /** @var Response $chunk */
        $texts = null;
        foreach ($conversationClient->conversation(     conversation: $conversation,
                                                        messages    : $messages,
                                                        store       : true,
                                                        stream      : true
        ) as $chunk) {

            if ($chunk->getType() !== 'conversation.response.done') {
                $texts .= $chunk->getChunk();
            }
        }

        $this->assertNotEmpty($texts);
        foreach($mcpConfig->getToolsList() as $tool) {
            $this->assertStringContainsString($tool, $texts);
        }

    }

    public function testPhpMistralStreamingCallToolOnce(): void
    {
        $apiKey = $this->apiKey;
        $model = $this->model;
        $number1 = rand(1, 100);
        $number2 = rand(1, 100);

        $configArray = [
            'mcp' => [
                'servers' => [
                    'test' => [
                        'command' => 'docker',
                        'args' => [
                            'run',
                            '-i',
                            '--rm',
                            'mcp/everything',
                        ],
                    ],
                ],
            ],
        ];

        $mcpConfig = new McpConfig(
            $configArray
        );

        $conversation = (new MistralConversation)
            ->setModel($model)
            ->setName('Test')
            ->setDescription('Conversation used for testing')
            ->setTools($mcpConfig);

        $conversationClient = new MistralConversationClient($apiKey);

        $messages = $conversationClient
            ->getMessages()
            ->addAssistantMessage('Do as the user requests')
            ->addUserMessage("Use the tool 'add' to add the numbers $number1 and $number2 and only return the result with nothing else");

        /** @var Response $chunk */
        $text = null;
        foreach ($conversationClient->conversation(
            conversation: $conversation,
            messages    : $messages,
            store       : true,
            stream      : true
        ) as $chunk) {

            if ($chunk->getType() !== 'conversation.response.done') {
                $text .= $chunk->getChunk();
            }

            if ($chunk->getType() === 'conversation.response.done') {
                $conversation->setId($chunk->getId());
            }
        }

        $this->assertNotEmpty($text);
        $this->assertEquals($number1 + $number2, (int) $text);
    }

}