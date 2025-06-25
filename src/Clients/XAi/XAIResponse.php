<?php

namespace Partitech\PhpMistral\Clients\XAi;

use DateMalformedStringException;
use Partitech\PhpMistral\Clients\Response;

class XAIResponse extends Response
{
    /**
     * @throws DateMalformedStringException
     */
    public static function updateFromArray(self|Response $response, array $data): Response
    {
        $response = parent::updateFromArray($response, $data);

        if(isset($data['system_fingerprint'])){
            $response->setFingerPrint($data['system_fingerprint']);
        }

        if(isset($data['request_id'])){
            $response->setId($data['request_id']);
        }

        return $response;
    }
}