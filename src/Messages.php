<?php

namespace Partitech\PhpMistral;

use ArrayObject;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Tools\ToolCallCollection;

class Messages
{
    public const ROLE_USER='user';
    public const ROLE_ASSISTANT='assistant';
    public const ROLE_TOOL='tool';
    public const ROLE_SYSTEM='system';

    private ArrayObject $messages;
    private ?array $document=null;

    private string $clientType;

    public function __construct(string $type = Client::TYPE_OPENAI)
    {
        $this->clientType = $type;
        $this->messages   = new ArrayObject();
    }

    public function getClientType(): string
    {
        return $this->clientType;
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
        $message = new Message(type: $this->clientType);
        $message->setRole(self::ROLE_SYSTEM);
        $message->setContent($content);
        $this->addMessage($message);
        return $this;
    }

    public function addUserMessage(string $content): self
    {
        $message = new Message(type: $this->clientType);
        $message->setRole(self::ROLE_USER);
        $message->setContent($content);
        $this->addMessage($message);
        return $this;
    }

    // deprecated
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
            'role' => self::ROLE_USER,
            'content' => $messageContent
        ];
    }

    public function addToolMessage(string $name, string|array $content, string $toolCallId): self
    {
        $message = new Message($this->clientType);
        if($this->clientType===CLIENT::TYPE_ANTHROPIC){
            $message->setRole(self::ROLE_USER);
            $message->setContent([[
                'type' => 'tool_result',
                'tool_use_id' => $toolCallId,
                'content' => (is_array($content)) ? reset($content) : $content
            ]]);

        }else{
            $message->setRole(self::ROLE_TOOL);
            $message->setContent($content);
            $message->setName($name);
            $message->setToolCallId($toolCallId);
        }

        $this->addMessage($message);

        return $this;
    }

    public function addAssistantMessage(null|string|array $content, null|array|ToolCallCollection $toolCalls = null): self
    {
        $message = new Message($this->clientType);
        $message->setRole(self::ROLE_ASSISTANT);
        $message->setContent(trim($content));
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

            if ($lastMessage->getRole() === self::ROLE_USER) {
                $lastMessage->setContent($lastMessage->getContent() . PHP_EOL . $msg);
                $messages[$lastIndex] = $lastMessage;
                $this->setMessages(new ArrayObject($messages));
            }
        }

        return $this;
    }

    public function addDocumentMessage(string $type, string $content): self
    {
        $this->document = [
            'type' => $type,
            $type => $content
        ];

        return $this;
    }

    public function getDocumentMessage(): ?array
    {
        return $this->document;
    }
    public function getSystemMessageContent(): ?string
    {
        foreach ($this->messages as $index => $message) {
            if ($message instanceof Message && $message->getRole() === self::ROLE_SYSTEM) {
                $this->messages->offsetUnset($index);
                return $message->getContent();
            }
        }
        return null;
    }

    public function removeSystemMessage(): self
    {
        $filtered = [];
        foreach ($this->messages as $message) {
            if ($message->role() !== self::ROLE_SYSTEM) {
                $filtered[] = $message;
            }
        }

        $this->messages = new ArrayObject($filtered);
        return $this;
    }


}
