<?php

namespace Partitech\PhpMistral\Clients\Anthropic;

use Partitech\PhpMistral\Clients\Response;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Tools\ToolCallFunction;

class AnthropicResponse extends Response
{
    protected string $finishedToolCallReason = 'tool_calls';
    public static function updateFromArray(self|Response $response, array $data): Response
    {
        $response = parent::updateFromArray($response, $data);

        /** @var Message $message */
        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count() - 1] : new Message();
        $message->setChunk(null); // prune chunk.

        if(isset($data['stop_reason']) && in_array($data['stop_reason'], ['end_turn', 'tool_use'])){
            $message->setStopReason($data['stop_reason']);
        }


        if($message->getStopReason() === 'end_turn' && isset($data['content'])){
            $message->setRole(Messages::ROLE_ASSISTANT);
            if(is_array($data['content'])){
                foreach($data['content'] as $anthropicContent) {
                    if (is_array($anthropicContent) &&($anthropicContent['text']) && is_string($anthropicContent['text'])) {
                        $message->setContent($anthropicContent['text']);
                        $response->addMessage($message);
                        return $response;
                    }
                }
            }
        }

        if($message->getStopReason() === 'tool_use' && isset($data['content'])) {
            $message->setRole(Messages::ROLE_ASSISTANT);
            if(is_array($data['content'])){
                foreach($data['content'] as $content){
                    if($content['type'] === 'text'){
                        $message->updateContent(content: $content['text']);
                    }

                    if($content['type'] === 'tool_use'){
                        $message->addToolCall(ToolCallFunction::fromArray($content));
                    }
                }
            }
            $response->addMessage($message);
        }

        if (isset($data['type']) && $data['type']==='text_delta') {
            $message->updateContent($data['text']);
            $message->setChunk($data['text']);
            $response->addMessage($message);
        }


        if(isset($data['type']) && $data['type']==='message_start' && isset($data['content_block']) && $data['content_block']['type'] === 'text'){
            $message->setRole(Messages::ROLE_ASSISTANT);
            $message->setChunk($data['content_block']['text']);
            $response->addMessage($message);
        }


        if ($data['type'] === 'content_block_delta' && is_array($data['delta']) && $data['delta']['type'] === 'text_delta') {
            $message->updateContent($data['delta']['text']);
            $message->setChunk($data['delta']['text']);
            $response->addMessage($message);
        }

        if (isset($data['type']) && $data['type']==='input_json_delta') {
            $message->updateToolCalls($data['partial_json']);
            $message->setChunk(null);
            $response->addMessage($message);
        }

        if(isset($data['type']) && $data['type']==='tool_use'){
            $message->setChunk(null);
            $functionCallParams = [
                'id' => $data['id'],
                'function' => [
                    'name' => $data['name'],
                    'arguments' => $data['input'],
                ]
            ];
            $message->setToolCall($functionCallParams);
        }

        if (
            isset($data['type'], $data['delta']['stop_reason']) &&
            $data['type'] === 'message_delta'
        ) {
            $message->setStopReason($data['delta']['stop_reason']);
            $response->addMessage($message);
        }


        if ($data['type'] === 'content_block_start' && $data['content_block']['type'] === 'tool_use') {
            $message->setChunk(null);
            $functionCallParams = [
                'id' => $data['content_block']['id'],
                'function' => [
                    'name' => $data['content_block']['name'],
                    'arguments' => $data['content_block']['input'],
                ]
            ];
            $message->setToolCall($functionCallParams);
        }

        if ($data['type'] === 'content_block_delta' && $data['delta']['type'] === 'input_json_delta') {
            $message->updateToolCalls( $data['delta']['partial_json']);
            $message->setChunk(null);
            $response->addMessage($message);
        }

        return $response;
    }




}