<?php

namespace Partitech\PhpMistral;

use ArrayObject;
use Partitech\PhpMistral\Clients\Client;

class Messages
{
    public const string ROLE_USER='user';
    public const string ROLE_ASSISTANT='assistant';
    public const string ROLE_TOOL='tool';
    public const string ROLE_SYSTEM='system';

    private ArrayObject $messages;
    private ?array $document=null;

    private string $type;

    public function __construct(string $type = Client::TYPE_OPENAI)
    {
        $this->type = $type;
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
        $message = new Message(type: $this->type);
        $message->setRole(self::ROLE_SYSTEM);
        $message->setContent($content);
        $this->addMessage($message);
        return $this;
    }

    public function addUserMessage(string $content): self
    {
        $message = new Message(type: $this->type);
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
        $message = new Message($this->type);
        if($this->type===CLIENT::TYPE_ANTHROPIC){
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

    public function addAssistantMessage(null|string|array $content, null|array $toolCalls = null): self
    {
        $message = new Message($this->type);
        $message->setRole(self::ROLE_ASSISTANT);
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

}
