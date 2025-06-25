<?php

namespace Partitech\PhpMistral\Clients\Ollama;

use DateMalformedStringException;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Message;

class OllamaResponse extends Response
{
    /**
     * @throws DateMalformedStringException
     */
    public static function updateFromArray(self|Response $response, array $data): Response
    {
        $response = parent::updateFromArray($response, $data);

        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count() - 1] : new Message();

        if (isset($data['message'])) {
            $message->setRole('assistant');
            if (isset($data['stream']) && $data['stream'] === true) {
                $message->updateContent($data['message']['content']);
                $message->setChunk($data['message']['content']);
            } else {
                $message->setContent($data['message']['content']);
            }
            $response->addMessage($message);
            return $response;
        }
        if(isset($data['status'])) {
            $message->updateContent($data['status']);
            $message->setChunk($data['status']);
            $response->addMessage($message);
            return $response;
        }

        return $response;
    }
}