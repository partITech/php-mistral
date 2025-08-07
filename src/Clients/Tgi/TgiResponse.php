<?php

namespace Partitech\PhpMistral\Clients\Tgi;

use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Tools\ToolCallFunction;

class TgiResponse extends Response
{

    public static function updateFromArray(self|Response $response, array $data): Response
    {
        $response = parent::updateFromArray($response, $data);
        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count() - 1] : new Message();

        if(isset($data['finish_reason']) && $data['finish_reason'] !== null){
            // patch if TGI/HuggingFace call a tool without parameters, by default the first tool setup is "{"
            // we need to avoid that.
            /** @var ToolCallFunction $toolCall */
            foreach($message->getToolCalls() as $toolCall){
                if($toolCall->getArguments() === ['{']){
                    $toolCall->updateArguments([]);
                }
            }

            $message->setStopReason('tool_calls');
        }

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