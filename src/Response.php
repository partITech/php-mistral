<?php

namespace Partitech\PhpMistral;

use ArrayObject;

class Response
{
    private string $id;
    private string $object;
    private int $created;
    private string $model;
    private ArrayObject $choices;


    private array $usage;

    public function __construct()
    {
        $this->choices = new ArrayObject();
    }

    public static function createFromArray(array $data): self
    {
        $response = new self();
        return self::updateFromArray($response, $data);
    }

    public static function updateFromArray(self $response, array $data): self
    {
        if (isset($data['id'])) {
            $response->setId($data['id']);
        }

        if (isset($data['object'])) {
            $response->setObject($data['object']);
        }

        if (isset($data['created'])) {
            $response->setCreated($data['created']);
        }

        if (isset($data['model'])) {
            $response->setModel($data['model']);
        }


        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count(
        ) - 1] : new Message();
        // Llama.cpp response
        if (isset($data['content'])) {
            $message->setRole('assistant');
            if (isset($data['stream']) && $data['stream'] === true) {
                $message->updateContent($data['content']);
                $message->setChunk($data['content']);
            } else {
                $message->setContent($data['content']);
            }
            $response->addMessage($message);
        }

        // Mistral platform response
        if (isset($data['choices'])) {
            foreach ($data['choices'] as $choice) {
                if (isset($choice['message']['role'])) {
                    $message->setRole($choice['message']['role']);
                }

                if (isset($choice['message']['content'])) {
                    $message->setContent($choice['message']['content']);
                }

                if (isset($choice['delta']['role'])) {
                    $message->setRole($choice['delta']['role']);
                }

                if (isset($choice['delta']['content'])) {
                    $message->updateContent($choice['delta']['content']);
                    $message->setChunk($choice['delta']['content']);
                }

                if (isset($choice['message']['tool_calls'])) {
                    $message->setToolCalls($choice['message']['tool_calls']);
                }

                if ($response->getChoices()->count() === 0) {
                    $response->addMessage($message);
                }
            }
        }
        if (isset($data['usage'])) {
            $response->setUsage($data['usage']);
        }

        return $response;
    }

    public function getChoices(): ArrayObject
    {
        return $this->choices;
    }

    public function setChoices(ArrayObject $choices): self
    {
        $this->choices = $choices;
        return $this;
    }

    public function addMessage(Message $message): self
    {
        $this->choices->append($message);

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getObject(): string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;
        return $this;
    }

    public function getCreated(): int
    {
        return $this->created;
    }

    public function setCreated(int $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getUsage(): array
    {
        return $this->usage;
    }

    public function setUsage(array $usage): self
    {
        $this->usage = $usage;
        return $this;
    }

    public function getToolCalls(): ?array
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getToolCalls();
    }

    private function getLastMessage(): Message
    {
        return $this->choices[$this->choices->count() - 1];
    }

    public function getChunk(): ?string
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getChunk();
    }

    public function getGuidedMessage(?bool $associative = null): null|object|array
    {
        if (is_string($this->getMessage()) && json_validate($this->getMessage())) {
            return json_decode($this->getMessage($associative));
        }

        return null;
    }

    public function getMessage(): ?string
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getContent();
    }
}
