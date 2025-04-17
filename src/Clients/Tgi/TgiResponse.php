<?php

namespace Partitech\PhpMistral\Clients\Tgi;

use DateMalformedStringException;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Message;

class TgiResponse extends Response
{
    /**
     * @throws DateMalformedStringException
     */
    public static function updateFromArray(self|Response $response, array $data): Response
    {
        $response = parent::updateFromArray($response, $data);

        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count() - 1] : new Message();

        if(isset($data[0]['generated_text'])) {
            $message->updateContent($data[0]['generated_text']);
            $message->setChunk($data[0]['generated_text']);
            if ($response->getChoices()->count() === 0) {
                $response->addMessage($message);
            }
        }
        if(isset($data['generated_text'])) {
            $message->updateContent($data['generated_text']);
            $message->setChunk($data['generated_text']);
            if ($response->getChoices()->count() === 0) {
                $response->addMessage($message);
            }
        }
        if(isset($data['token']) && is_array($data['token']) && isset($data['token']['text'])) {
            $message->updateContent($data['token']['text']);
            $message->setChunk($data['token']['text']);
            if ($response->getChoices()->count() === 0) {
                $response->addMessage($message);
            }
        }

        return $response;
    }
}