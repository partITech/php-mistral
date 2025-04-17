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


    public function getGuidedMessage(?bool $associative = null): null|object|array
    {
        if(is_array($this->getMessage()) && array_is_list($this->getMessage())){
            foreach($this->getMessage() as $messagePart){
                if(isset($messagePart['type']) && $messagePart['type'] ==='tool_use' && isset($messagePart['input']) && is_array($messagePart['input'])){
                    return $messagePart['input'];
                }
            }
        }

        if (is_string($this->getMessage()) && json_validate($this->getMessage())) {
            return json_decode($this->getMessage(), $associative);
        }

        return null;
    }
}