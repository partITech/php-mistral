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
                $messages[] = $message->toArray();
            }
            return $messages;
        }

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

    public function addAssistantMessage(string $content): self
    {
        $message = new Message();
        $message->setRole('assistant');
        $message->setContent($content);
        $this->addMessage($message);
        return $this;
    }
}
