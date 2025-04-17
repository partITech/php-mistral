<?php

namespace Partitech\PhpMistral\Clients\LlamaCpp;

use DateMalformedStringException;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

class LlamaCppResponse extends Response
{
    /**
     * @throws DateMalformedStringException
     */
    public static function updateFromArray(self|Response $response, array $data): Response
    {
        $response = parent::updateFromArray($response, $data);

        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count() - 1] : new Message();

        if (isset($data['content']) && is_string($data['content'])) {
            $message->setRole('assistant');
            if (isset($data['stream']) && $data['stream'] === true) {
                $message->updateContent($data['content']);
                $message->setChunk($data['content']);
            } else {
                $message->setContent($data['content']);
            }
            $response->addMessage($message);
            return $response;
        }

        return $response;
    }

}