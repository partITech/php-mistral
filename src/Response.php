<?php

namespace Partitech\PhpMistral;

use ArrayObject;
use DateMalformedStringException;
use DateTime;
use DateTimeZone;
use Throwable;

class Response
{
    private ?string $id=null;
    private string $object='chat.completion';
    private int $created;
    private string $model;
    private ArrayObject $choices;
    private ?array $pages;


    private array $usage=[];

    public function __construct()
    {
        $this->choices = new ArrayObject();
    }

    /**
     * @throws MistralClientException
     */
    public static function createFromArray(array $data): self
    {
        $response = new self();
        try{
            $self = self::updateFromArray($response, $data);
        }catch(Throwable $e){
            throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
        }

        return $self;
    }

    public static function createFromJson(string $json, bool $stream = false): ?self
    {
        if(json_validate($json)) {
            $datas = json_decode($json, true);
            $datas['stream'] = $stream;
            try{
                return self::createFromArray($datas);
            }catch(Throwable $e){
                new MistralClientException($e->getMessage(), $e->getCode(), $e);
            }
        }

        return null;
    }

    /**
     * @throws DateMalformedStringException
     */
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

        if (isset($data['created_at'])) {
            if(is_string($data['created_at'])) {
                $data['created_at'] = self::isoToTimestamp($data['created_at']);
            }
            $response->setCreated($data['created_at']);
        }

        if (isset($data['model'])) {
            $response->setModel($data['model']);
        }


        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count() - 1] : new Message();

        // Ollama response

        if (isset($data['message'])) {
            $message->setRole('assistant');
            if (isset($data['stream']) && $data['stream'] === true) {
                $message->updateContent($data['message']['content']);
                $message->setChunk($data['message']['content']);
            } else {
                $message->setContent($data['message']['content']);
            }
            $response->addMessage($message);
            return $response;
        }
        if(isset($data['status'])) {
            $message->updateContent($data['status']);
            $message->setChunk($data['status']);
            $response->addMessage($message);
            return $response;
        }



        // Llama.cpp responses
        if (isset($data['content']) ) {
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

                if (isset($choice['text'])) {
                    if(is_null($message->getRole())){
                        $message->setRole(Message::MESSAGE_TYPE_TEXT);
                    }
                    $message->setContent($choice['text']);
                    $message->setChunk($choice['text']);
                }

                if ($response->getChoices()->count() === 0) {
                    $response->addMessage($message);
                }
            }
        }

        // TGI generate
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


        // chat response
        if (isset($data['usage'])) {
            $response->setUsage($data['usage']);
        }

        // ocr response
        if (isset($data['usage_info'])) {
            $response->setUsage($data['usage_info']);
        }
        if (isset($data['pages'])) {
            $response->setPages($data['pages']);
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

//    public function addMessage(Message $message): self
//    {
//        $this->choices->append($message);
//
//        return $this;
//    }

    public function addMessage(Message $message): self
    {
        // if empty, automatically add
        if ($this->choices->count() === 0) {
            $this->choices->append($message);
            return $this;
        }

        $arrayCopy = $this->choices->getArrayCopy();
        $lastKey = array_key_last($arrayCopy);
        /** @var Message $lastChoice */
        $lastChoice = $arrayCopy[$lastKey];

        if ($lastChoice->getRole() === $message->getRole()) {
            // Replace the last message
            $this->choices[$lastKey] = $message;
        } else {
            // Add new message if roles are different
            $this->choices->append($message);
        }

        return $this;
    }

    public function getId(): string
    {
        if(is_null($this->id)) {
            $this->id = uniqid();
        }
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
            return json_decode($this->getMessage(), $associative);
        }

        return null;
    }

    public function getMessage(): ?string
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getContent();
    }

    /**
     * @throws DateMalformedStringException
     */
    public static function isoToTimestamp($isoDateString): int
    {
        // ISO 8601
        $dateTime = new DateTime($isoDateString, new DateTimeZone('UTC'));
        return $dateTime->getTimestamp();
    }

    public function setPages(array $pages): self
    {
        $this->pages = $pages;
        return $this;
    }

    public function getPages(): ?array
    {
        return $this->pages;
    }

}
