<?php

namespace Partitech\PhpMistral;

use ArrayObject;

class Messages
{

    private ArrayObject $messages;

    public function __construct()
    {
        $this->messages = new ArrayObject();
    }


    /**
     * @return ArrayObject
     */
    public function getMessages(): ArrayObject
    {
        return $this->messages;
    }

    public function format(string $format=MistralClient::CHAT_ML): string|array|null
    {
        if(MistralClient::CHAT_ML === $format) {
            $messages = [];
            foreach($this->getMessages() as $message) {
                if(!is_array($message)) {
                    $messageArray = $message->toArray();
                }else{
                    $messageArray = $message;
                }
                $messages[] = $messageArray;
            }
            return $messages;
        }

        /** @deprecated since v0.0.16. Will be removed in the future version. */
        if(MistralClient::COMPLETION === $format) {
            $messages = null;

            $collection = $this->getMessages();
            $iterator = $collection->getIterator();

            $first = $iterator->current();
            $iterator->seek($collection->count() - 1);
            $last = $iterator->current();
            $between = new ArrayObject();

            if ($collection->count() > 2) {
                $iterator->rewind();
                $iterator->next(); // pass the first
                while ($iterator->valid()) {
                    // do not get the last
                    if ($iterator->key() < $collection->count() - 1) {
                        $between->append($iterator->current());
                    }
                    $iterator->next();
                }
            }


            $messages .= '<s> [INST] ' . $first->getContent() . ' [/INST] </s> ';

            $prevType='system';
            /** @var Message $message */
            foreach($between as $message) {
                if($message->getRole() === 'system' || $message->getRole() === 'user') {
                    $prevType='system';
                    $messages .= '<s> [INST] ' . $message->getContent() . '[/INST]';
                }

                if($message->getRole() === 'assistant' && $prevType === 'system') {
                    $prevType='assistant';
                    $messages .= ' ' . $message->getContent() . '</s> ';
                }
            }

            $messages .= ' [INST] ' . $last->getContent() . ' [/INST]';
            return $messages;
        }

        return null;
    }

    /**
     * @param ArrayObject $messages
     */
    public function setMessages(ArrayObject $messages): void
    {
        $this->messages = $messages;
    }

    public function addMessage(Message $message): self
    {
        $this->messages->append($message);
        return $this;
    }

    public function addSystemMessage(string $content): self
    {
        $message = new Message();
        $message->setRole('system');
        $message->setContent($content);
        $this->addMessage($message);
        return $this;
    }

    public function addUserMessage(string $content): self
    {
        $message = new Message();
        $message->setRole('user');
        $message->setContent($content);
        $this->addMessage($message);
        return $this;
    }

    public function addMixedContentUserMessage(array $contents): void
    {
        $messageContent = [];
        foreach ($contents as $content) {
            if (isset($content['type']) && $content['type'] === 'text') {
                $messageContent[] = ['type' => 'text', 'text' => $content['text']];
            } elseif (isset($content['type']) && $content['type'] === 'image_url') {
                $messageContent[] = ['type' => 'image_url', 'image_url' => ['url' => $content['image_url']]];
            }
        }
        $this->messages[] = [
            'role' => 'user',
            'content' => $messageContent
        ];
    }

    public function addToolMessage(string $name, array $content, string $toolCallId): self
    {
        $message = new Message();
        $message->setRole('tool');
        $message->setContent($content);
        $message->setName($name);
        $message->setToolCallId($toolCallId);
        $this->addMessage($message);
        return $this;
    }

    public function addAssistantMessage(null|string $content, null|array $toolCalls = null): self
    {
        $message = new Message();
        $message->setRole('assistant');
        $message->setContent($content);
        $message->setToolCalls($toolCalls);
        $this->addMessage($message);
        return $this;
    }
}
