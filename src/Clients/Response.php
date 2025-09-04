<?php

namespace Partitech\PhpMistral\Clients;

use ArrayObject;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use Partitech\PhpMistral\Exceptions\MistralClientException;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Tools\ToolCallCollection;
use Partitech\PhpMistral\Tools\ToolCallFunction;
use Partitech\PhpMistral\Utils\Json;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Throwable;

class Response
{
    public const THINKING_WORDS = [
        '<think>',
        '</think>'
    ];

    private ?string     $id     = null;
    private string      $object = 'chat.completion';
    private int         $created;
    private string      $model;
    private string      $fingerPrint;
    private ArrayObject $choices;
    private ?array      $pages;
    private ?string      $clientType;

    private array $usage = [];

    public function __construct(null|string $clientType = null)
    {
        $this->choices = new ArrayObject();
        $this->clientType = $clientType;
        if (is_string($clientType)) {
            $this->createFirstMessage($clientType);
        }
    }

    public function createFirstMessage(string $type): self
    {
        $this->addMessage(new Message($type));

        return $this;
    }

    public function updateLastMessage(Message $message): self
    {
        $this->choices[$this->choices->count() - 1] = $message;

        return $this;
    }

    public function addMessage(Message $message): self
    {
        // if empty, automatically add
        if ($this->choices->count() === 0) {
            $this->choices->append($message);
            return $this;
        }

        $arrayCopy = $this->choices->getArrayCopy();
        $lastKey   = array_key_last($arrayCopy);
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

    public static function createFromJson(string $json, bool $stream = false): ?self
    {
        if (Json::validate($json)) {
            $datas           = json_decode($json, true);
            $datas['stream'] = $stream;
            try {
                return static::createFromArray($datas, Client::TYPE_OPENAI);
            } catch (Throwable $e) {
                new MistralClientException($e->getMessage(), $e->getCode(), $e);
            }
        }

        return null;
    }

    /**
     * @throws MistralClientException
     */
    public static function createFromArray(array $data, string $clientType): self
    {
        $response = new static($clientType);

        try {
            $self = static::updateFromArray($response, $data);
        } catch (Throwable $e) {
            throw new MistralClientException($e->getMessage(), $e->getCode(), $e);
        }

        return $self;
    }

    /**
     * @throws Exception
     */
    public static function updateFromArray(self $response, array $data): Response
    {
        if (isset($data['id']) && $response->getId() === null) {
            $response->setId($data['id']);
        }

        if (isset($data['object'])) {
            $response->setObject($data['object']);
        }

        if (isset($data['conversation_id'])) {
            $response->setId($data['conversation_id']);
        }

        if (isset($data['created'])) {
            $response->setCreated($data['created']);
        }

        if (isset($data['created_at'])) {
            if (is_string($data['created_at'])) {
                $data['created_at'] = self::isoToTimestamp($data['created_at']);
            }
            $response->setCreated($data['created_at']);
        }

        if (isset($data['model'])) {
            $response->setModel($data['model']);
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

        $message = $response->getChoices()->count() > 0 ? $response->getChoices()[$response->getChoices()->count(
        ) - 1] : new Message($response->clientType);

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
                    $choice['delta']['content'] = str_replace(self::THINKING_WORDS, '', $choice['delta']['content']);
                    $message->updateContent($choice['delta']['content']);
                    $message->setChunk($choice['delta']['content']);
                } else {
                    $message->setChunk(null);
                }

                if (isset($choice['delta']['tool_calls']) && is_array($choice['delta']['tool_calls']) && count(
                        $choice['delta']['tool_calls']
                    ) > 0) {
                    $toolCallIndex = $choice['delta']['tool_calls'][$choice['index']]['index'];
                    $toolCallId    = $choice['delta']['tool_calls'][$choice['index']]['id'] ?? null;

                    if ($message->getToolCallByIdOrIndex($toolCallId, $toolCallIndex) === null) {
                        foreach ($choice['delta']['tool_calls'] as $toolCallDefinition) {
                            $toolCallFunction = ToolCallFunction::fromArray($toolCallDefinition);
                            $message->addToolCall($toolCallFunction);
                        }
                    }

                    foreach ($choice['delta']['tool_calls'] as $toolCall) {
                        if (isset($toolCall['function']['arguments'])) {
                            $message->updateToolCalls(
                                $toolCall['function']['arguments'],
                                (int)$toolCall['index'] ?? $toolCall['id']
                            );
                        }
                    }
                }

                if (isset($choice['message']['tool_calls'])) {
                    foreach ($choice['message']['tool_calls'] as $toolCall) {
                        $toolCallFunction = ToolCallFunction::fromArray($toolCall);
                        $message->addToolCall($toolCallFunction);
                    }
                }

                if (isset($choice['text'])) {
                    if (is_null($message->getRole())) {
                        $message->setRole(Message::MESSAGE_TYPE_TEXT);
                    }
                    $message->setContent($choice['text']);
                    $message->setChunk($choice['text']);
                }

                if (isset($choice['finish_reason'])) {
                    $message->setStopReason($choice['finish_reason']);
                }

                if ($response->getChoices()->count() === 0) {
                    $response->addMessage($message);
                } else {
                    $response->updateLastMessage($message);
                }
            }
            return $response;
        }
        if (isset($data['finish_reason'])) {
            $message->setStopReason($data['finish_reason']);
            $response->updateLastMessage($message);
        }

        if(isset($data['outputs'])) {
            foreach ($data['outputs'] as $output) {
                $message = new Message($response->clientType);

                if(isset($output['role'])){
                    $message->setRole($output['role']);
                }

                if(isset($output['content']) && is_string($output['content']) ){
                    $message->setContent($output['content']);
                }


                if(isset($output['id'])){
                    $message->setId($output['id']);
                }

                if(isset($output['created_at'])){
                    $message->setCreatedAt(new DateTimeImmutable($output['created_at']));
                }

                if(isset($output['completed_at'])){
                    $message->setCompletedAt(new DateTimeImmutable($output['completed_at']));
                }

                if(isset($output['type']) &&  $output['type'] === 'tool.tool_reference' ){
                    $message->addReference($output);
                }

                if(isset($output['type']) &&  $output['type'] === 'message.output' && isset($output['content']) && is_array($output['content'])){
                    foreach ( $output['content'] as $content) {
                        if($content['type'] === 'text'){
                            $message->updateContent($content['text']);
                        }

                        if($content['type'] === 'tool_reference'){
                            $message->addReference($content);
                        }
                    }
                }


                if(isset($output['type']) &&  $output['type'] === 'tool.execution'){
                    $toolCallFunction = ToolCallFunction::fromArray(
                        [
                            'type' => 'tool_use',
                            'id' => $output['id'],
                            'name' => $output['name'],
                            'arguments' => $output['arguments'],
                            'input' => [],
                        ]
                    );
                    $message->addToolCall($toolCallFunction);
                }

                if(isset($output['type']) && $output['type'] === 'function.call'){
                    $toolCallFunction = ToolCallFunction::fromArray(
                        [
                            'type' => 'tool_use',
                            'id' => $output['tool_call_id'],
                            'name' => $output['name'],
                            'arguments' =>  $output['arguments'],
                            'input' => [],
                        ]
                    );
                    $message->addToolCall($toolCallFunction);
                    $message->setStopReason('tool_calls');
                }


                if ($response->getChoices()->count() === 0) {
                    $response->addMessage($message);
                } else {
                    $response->updateLastMessage($message);
                }
            }
        }

        if(isset($data['type']) && in_array($data['type'], ['function.call.delta'])){
            if ($message->getToolCallByIdOrIndex($data['tool_call_id'], $data['output_index']) === null) {

                $message->setType($data['type']);
                $toolCallFunction = ToolCallFunction::fromArray($data);
                $message->addToolCall($toolCallFunction);

            } else {
                $toolCall = $message->getToolCallByIdOrIndex($data['tool_call_id'], $data['output_index']);
                $message->setType($data['type']);
                $message->updateToolCalls(
                    $data['arguments'],
                    $toolCall->getIndex()
                );

            }

        }

        if(isset($data['type']) && in_array($data['type'], ['message.output.delta', 'conversation.response.done', 'conversation.response.started'])){
            $message->setType($data['type']);
            if(isset($data['created_at']) && is_string($data['created_at'])){
                $message->setCreatedAt(new DateTimeImmutable($data['created_at']));
            }

            if(isset($data['created_at']) && is_int($data['created_at'])){
                $message->setCreatedAt((new DateTimeImmutable())->setTimestamp($data['created_at']));
            }

            if(isset($data['id'])){
                $message->setId($data['id']);
            }

            if(isset($data['conversation_id'])){
                $message->setId($data['conversation_id']);
            }

            if(isset($data['role'])){
                $message->setRole($data['role']);
            }

            if(isset($data['content']) && is_string($data['content']) ){
                $message->setContent($data['content']);
                $message->setChunk($data['content']);
            }

            if(isset($data['content']) && is_array($data['content']) && isset($data['content']['type']) && $data['content']['type'] === 'tool_reference' ){
                $message->addReference($data['content']);
            }

            if(isset($data['type']) && in_array($data['type'], ['message.output.delta', 'conversation.response.done']) && $message->getStopReason() === null){
                $message->setStopReason('stop');
            }

            if ($response->getChoices()->count() === 0) {
                $response->addMessage($message);
            } else {
                $response->updateLastMessage($message);
            }
        }

        return $response;
    }

    /**
     * @throws Exception
     */
    public static function isoToTimestamp($isoDateString): int
    {
        // ISO 8601
        $dateTime = new DateTime($isoDateString, new DateTimeZone('UTC'));
        return $dateTime->getTimestamp();
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

    public function getToolCalls(): ?ToolCallCollection
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getToolCalls();
    }

    public function getLastMessage(): Message
    {
        return $this->choices[$this->choices->count() - 1];
    }

    public function getMessage(): null|array|string
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getContent();
    }

    public function getId(): string
    {
        if (is_null($this->id)) {
            $this->id = uniqid();
        }
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
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

    public function updateUsage(string $key, mixed $value): self
    {
        $this->usage[$key] = $value;

        return $this;
    }

    public function getChunk(): ?string
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getChunk();
    }

    /**
     * @return null|object|array<string, mixed>
     */
    public function getGuidedMessage(?bool $associative = null): null|object|array
    {
        if (is_array($this->getMessage()) && array_is_list($this->getMessage())) {
            foreach ($this->getMessage() as $messagePart) {
                if (isset($messagePart['type']) && $messagePart['type'] === 'tool_use' && isset($messagePart['input']) && is_array(
                        $messagePart['input']
                    )) {
                    return $messagePart['input'];
                }
            }
        }

        if (is_string($this->getMessage()) && Json::validate($this->getMessage())) {
            return json_decode($this->getMessage(), $associative);
        }

        return null;
    }

    public function getPages(): ?array
    {
        return $this->pages;
    }

    public function setPages(array $pages): self
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @return string
     */
    public function getFingerPrint(): string
    {
        return $this->fingerPrint;
    }

    /**
     * @param string $fingerPrint
     * @return Response
     */
    public function setFingerPrint(string $fingerPrint): Response
    {
        $this->fingerPrint = $fingerPrint;
        return $this;
    }

    public function shouldTriggerMcp(): bool
    {
        $stopReasons = ['tool_calls', 'tool_use', 'stop'];
        $toolCalls   = $this->getToolCalls();

        if (!in_array($this->getStopReason(), $stopReasons)) {
            return false;
        }

        if (!$toolCalls instanceof ToolCallCollection || $toolCalls->count() === 0) {
            return false;
        }

        return true;
    }

    public function getStopReason(): ?string
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getStopReason();
    }

    public function getType(): ?string
    {
        if($this->choices->count() === 0){
            return null;
        }

        if($this->getLastMessage()->getType()!==null){
            return $this->getLastMessage()->getType();
        }elseif ($this->getObject()!==null){
            return $this->getObject();
        }

        return null;
    }

    public function getObject(): string
    {
        return $this->object;
    }

    public function getReferences(): ?array
    {
        return $this->choices->count() === 0 ? null : $this->getLastMessage()->getReferences();
    }

    public function getFirstMessage(): Message
    {
        return $this->choices->getIterator()->current();
    }

}
