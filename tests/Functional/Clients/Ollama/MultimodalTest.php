<?php

namespace Tests\Functional\Clients\Ollama;

use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Message;

/**
 * Class MultimodalTest
 *
 * This class contains functional tests for multimodal interactions using the Mistral client.
 * It verifies the handling of textual and image-based multimodal requests.
 */
class MultimodalTest extends Setup
{
    /**
     * @var string Vision model used for multimodal interactions.
     */
    protected string $visionModel = 'gemma3:4b';

    /**
     * Test multimodal interaction using the vision model with text and image inputs.
     *
     * @throws MistralClientException
     */
    public function testMultimodalInteraction(): void
    {
        // Ensure the required vision model is loaded
        $this->client->requireModel($this->visionModel);

        // Create a new message with text and image content
        $message = $this->client->newMessage();
        $message->setRole('user');
        $message->addContent(
            type: Message::MESSAGE_TYPE_TEXT,
            content: 'Describe images'
        );
        $message->addContent(
            type: Message::MESSAGE_TYPE_BASE64,
            content: realpath('./tests/medias/pixtral_image_example_charts.jpeg')
        );

        // Add the message to the client
        $messages = $this->client->getMessages()->addMessage($message);

        try {
            // Send the multimodal request to the client
            $response = $this->client->chat(
                $messages,
                [
                    'model' => $this->visionModel,
                    'max_tokens' => 1024,
                ]
            );

            // Retrieve and validate the response
            $resultMessage = $response->getMessage();
            $this->assertNotEmpty($resultMessage, 'The multimodal response message should not be empty.');
            $this->assertStringContainsString(
                'France',
                $resultMessage,
                'The response should include details for "France".'
            );

            // Log the response for debugging purposes
            $this->consoleNote($resultMessage);

        } catch (\Throwable $e) {
            // If an error occurs, mark the test as failed with the error message
            $this->fail('Multimodal interaction failed with error: ' . $e->getMessage());
        }
    }

    /**
     * Test multimodal interaction by downloading an image to a temporary file.
     *
     * @throws MistralClientException
     */
    public function testMultimodalDownloadToTmp(): void
    {
        // Ensure the required vision model is loaded
        $this->client->requireModel($this->visionModel);

        // Create a new message with text and an image downloaded to a temporary file
        $message = $this->client->newMessage();
        $message->setRole('user');
        $message->addContent(
            type: Message::MESSAGE_TYPE_TEXT,
            content: 'Describe image'
        );
        $message->addContent(
            type: Message::MESSAGE_TYPE_BASE64,
            content: $this->client->downloadToTmp('https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg')
        );

        // Add the message to the client
        $messages = $this->client->getMessages()->addMessage($message);

        try {
            // Send the multimodal request to the client
            $response = $this->client->chat(
                $messages,
                [
                    'model' => $this->visionModel,
                    'max_tokens' => 1024,
                    'seed' => 15,
                ]
            );

            // Retrieve and validate the response
            $resultMessage = $response->getMessage();
            $this->assertNotEmpty($resultMessage, 'The multimodal response message should not be empty.');
            $this->assertStringContainsString(
                'family',
                $resultMessage,
                'The response should include details for "family".'
            );
            $this->assertStringContainsString(
                'green',
                $resultMessage,
                'The response should include details for "green".'
            );

            // Log the response for debugging purposes
            $this->consoleNote($resultMessage);

        } catch (\Throwable $e) {
            // If an error occurs, mark the test as failed with the error message
            $this->fail('Multimodal interaction failed with error: ' . $e->getMessage());
        }
    }
}