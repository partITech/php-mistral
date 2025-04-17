<?php

namespace Partitech\PhpMistral\Clients\Anthropic;

use DateMalformedStringException;
use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

class AnthropicResponse extends Response
{
    /**
     * @throws DateMalformedStringException
     */
    public static function updateFromArray(self|Response $response, array $data): Response
    {
        $response = parent::updateFromArray($response, $data);

        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count() - 1] : new Message();
        if(isset($data['stop_reason']) && $data['stop_reason']==='end_turn' && isset($data['content'])){
            $message->setRole(Messages::ROLE_ASSISTANT);

            foreach($data['content'] as $anthropicContent) {
                if (isset($anthropicContent['text'])) {
                    $message->setContent($anthropicContent['text']);
                    $response->addMessage($message);
                    return $response;
                }
            }
        }
        if(isset($data['stop_reason']) && $data['stop_reason']==='tool_use' && isset($data['content'])) {
            $message->setRole(Messages::ROLE_ASSISTANT);
            foreach($data['content'] as $content){
                if($content['type'] === 'text'){
                    $message->updateContent(content: $content, asArray:true);
                }

                if($content['type'] === 'tool_use'){
                    $message->updateContent(content: $content, asArray:true);
                    $functionCallParams = [
                        'id' => $content['id'],
                        'function' => [
                            'name' => $content['name'],
                            'arguments' => $content['input'],
                        ]
                    ];
                    $message->setToolCall($functionCallParams);
                }
            }
            $response->addMessage($message);
        }

        if (isset($data['type']) && $data['type']==='text_delta') {
            $message->updateContent($data['text']);
            $message->setChunk($data['text']);
            $response->addMessage($message);

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