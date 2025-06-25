<?php

namespace Partitech\PhpMistral\Clients\LlamaCpp;

use DateMalformedStringException;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Message;

class LlamaCppResponse extends Response
{
    /**
     * @throws DateMalformedStringException
     */
    public static function updateFromArray(self|Response $response, array $data): Response
    {
        if (isset($data['choices'])) {
            foreach ($data['choices'] as &$choice) {
                if (isset($choice['message']['reasoning_content']) && is_string(
                        $choice['message']['reasoning_content']
                    ) && !empty($choice['message']['reasoning_content']) && empty($choice['message']['content'])) {
                    $choice['message']['content'] = $choice['message']['reasoning_content'];
                }
            }
        }
        $response = parent::updateFromArray($response, $data);

        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count() - 1] : new Message();

        if (isset($data['reasoning_content']) && is_string($data['reasoning_content']) && !empty($data['reasoning_content'])) {
            $data['content'] = $data['reasoning_content'];
        }

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