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

    public function format(): string|array
    {
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

    public function prependLastMessage(string $msg): self
    {
        $messages = $this->getMessages()->getArrayCopy();

        if (!empty($messages)) {
            $lastIndex = count($messages) - 1;

            /** @var Message $lastMessage */
            $lastMessage = $messages[$lastIndex];

            if ($lastMessage->getRole() === 'user') {
                $lastMessage->setContent($lastMessage->getContent() . PHP_EOL . $msg);
                $messages[$lastIndex] = $lastMessage;
                $this->setMessages(new ArrayObject($messages));
            }
        }

        return $this;
    }

}
