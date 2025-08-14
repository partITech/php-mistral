<?php

namespace Tests\Functional\Clients\vLLM;

use Partitech\PhpMistral\Message;

class MultimodalTest extends Setup
{
    protected string $visionModel = 'gemma3:4b';

    public function testMultimodalInteraction(): void
    {
        $message = $this->visionClient->newMessage();
        $message->setRole('user');
        $message->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'Describe images');
        $message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: realpath('./tests/medias/pixtral_image_example_charts.jpeg'));
        $messages = $this->client->getMessages()->addMessage($message);

        try {
            // Envoi de la requête multimodal
            $response = $this->visionClient->chat(
                $messages,
                [
                    'model' => $this->visionModel,
                    'max_tokens' => 512,
                    'seed' => 15,
                ]
            );

            // Récupération et validation de la réponse
            $resultMessage = $response->getMessage();
            $this->assertNotEmpty($resultMessage, 'The multimodal response message should not be empty.');
            $this->assertStringContainsString('France', $resultMessage, 'The response should include details for "France".');

            $this->consoleNote($resultMessage);
        } catch (\Throwable $e) {
            $this->fail('Multimodal interaction failed with error: ' . $e->getMessage());
        }
    }

    public function testMultimodalDownloadToTmp(): void
    {
        $message = $this->visionClient->newMessage();
        $message->setRole('user');
        $message->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'Describe image');
        $message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: $this->client->downloadToTmp('https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg'));
        $messages = $this->client->getMessages()->addMessage($message);

        try {
            // Envoi de la requête multimodal
            $response = $this->visionClient->chat(
                $messages,
                [
                    'model' => $this->visionModel,
                    'max_tokens' => 512,
                    'seed' => 15,
                ]
            );

            // Récupération et validation de la réponse
            $resultMessage = $response->getMessage();
            $this->assertNotEmpty($resultMessage, 'The multimodal response message should not be empty.');
            $this->assertStringContainsString('family', $resultMessage, 'The response should include details for "family".');
            $this->assertStringContainsString('green', $resultMessage, 'The response should include details for "France".');
            $this->consoleNote($resultMessage);
        } catch (\Throwable $e) {
            $this->fail('Multimodal interaction failed with error: ' . $e->getMessage());
        }
    }
}