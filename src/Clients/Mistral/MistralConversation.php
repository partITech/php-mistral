<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use DateTimeImmutable;
use Exception;
use Partitech\PhpMistral\Mcp\McpConfig;

class MistralConversation
{
    private ?string $agentId = null;
    private ?string $id      = null;
    private ?string $instructions = null;
    private array|McpConfig   $tools = [];

    // Store full completion_args as an array
    private ?array $completionArgs = [];

    // Completion arguments broken out
    private null|array|string $stop;
    private null|float        $presencePenalty;
    private null|float        $frequencyPenalty;
    private float             $temperature;
    private null|float        $topP;
    private null|int          $maxTokens;
    private null|int          $randomSeed;
    private null|array        $prediction;
    private null|array        $responseFormat;
    private string            $toolChoice;
    private ?string           $name;
    private ?string           $description;
    private ?string           $object;
    private ?string            $model;
    private string $handoffExecution = 'server';
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct() { }

    /**
     * Hydrate from API array.
     *
     * @throws Exception
     */
    public static function fromArray(array $data): self
    {
        $conv               = new self();
        $conv->agentId      = $data['agent_id'] ?? null;
        $conv->id           = $data['id'];
        $conv->instructions = $data['instructions'] ?? null;
        $conv->tools        = $data['tools'] ?? [];

        // Full completion_args
        $ca                   = $data['completion_args'] ?? [];
        $conv->completionArgs = $ca;

        // Broken-out values
        $conv->stop             = $ca['stop'] ?? null;
        $conv->presencePenalty  = isset($ca['presence_penalty']) ? floatval($ca['presence_penalty']) : null;
        $conv->frequencyPenalty = isset($ca['frequency_penalty']) ? floatval($ca['frequency_penalty']) : null;
        $conv->temperature      = isset($ca['temperature']) ? floatval($ca['temperature']) : 0.3;
        $conv->topP             = isset($ca['top_p']) ? floatval($ca['top_p']) : null;
        $conv->maxTokens        = isset($ca['max_tokens']) ? intval($ca['max_tokens']) : null;
        $conv->randomSeed       = isset($ca['random_seed']) ? intval($ca['random_seed']) : null;
        $conv->prediction       = $ca['prediction'] ?? null;
        $conv->responseFormat   = $ca['response_format'] ?? null;
        $conv->toolChoice       = $ca['tool_choice'] ?? 'auto';

        $conv->name        = $data['name'] ?? null;
        $conv->description = $data['description'] ?? null;
        $conv->object      = $data['object'] ?? null;
        $conv->model       = $data['model'] ?? null;
        $conv->createdAt   = new DateTimeImmutable($data['created_at']);
        $conv->updatedAt   = new DateTimeImmutable($data['updated_at']);
        return $conv;
    }

    /**
     * @return string
     */
    public function getHandoffExecution(): string
    {
        return $this->handoffExecution;
    }

    /**
     * @param string $handoffExecution
     * @return MistralConversation
     */
    public function setHandoffExecution(string $handoffExecution): MistralConversation
    {
        $this->handoffExecution = $handoffExecution;
        return $this;
    }

    /**
     * Return full payload for creating/updating a conversation.
     */
    public function toArray(): array
    {
        $arr = [
            'name'            => $this->name,
            'description'     => $this->description,
            'instructions'    => $this->instructions,
            'tools'           => $this->tools,
            'completion_args' => $this->completionArgs,
        ];

        if ($this->agentId !== null) {
            $arr['agent_id'] = $this->agentId;
        } else {
            $arr['model'] = $this->model;
        }

        return array_filter($arr, fn($v) => $v !== null);
    }

    public function getAgentId(): ?string
    {
        return $this->agentId;
    }

    /**
     * @param string|null $agentId
     * @return MistralConversation
     */
    public function setAgentId(?string $agentId): MistralConversation
    {
        $this->agentId = $agentId;
        return $this;
    }

    /**
     * @param string|null $agentId
     * @return MistralConversation
     */
    public function setAgent(MistralAgent $agent): MistralConversation
    {
        $this->agentId = $agent->getId();
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return MistralConversation
     */
    public function setId(string $id): MistralConversation
    {
        $this->id = $id;
        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    /**
     * @param string|null $instructions
     * @return MistralConversation
     */
    public function setInstructions(?string $instructions): MistralConversation
    {
        $this->instructions = $instructions;
        return $this;
    }

    public function getTools(): array|McpConfig
    {
        return $this->tools;
    }

    /**
     * @param array $tools
     * @return MistralConversation
     */
    public function setTools(array|McpConfig $tools): MistralConversation
    {
        $this->tools = $tools;
        return $this;
    }

    /**
     * Return the full completion_args payload.
     */
    public function getCompletionArgs(): ?array
    {
        if(is_array($this->completionArgs) && count($this->completionArgs) == 0 ){
            return null;
        }

        if(!is_array($this->completionArgs)){
            return null;
        }
        return $this->completionArgs;
    }

    /**
     * @param array $completionArgs
     * @return MistralConversation
     */
    public function setCompletionArgs(array $completionArgs): MistralConversation
    {
        $this->completionArgs = $completionArgs;
        return $this;
    }

    public function getStop(): null|array|string
    {
        return $this->stop;
    }

    /**
     * @param array|string|null $stop
     * @return MistralConversation
     */
    public function setStop(array|string|null $stop): MistralConversation
    {
        $this->stop = $stop;
        return $this;
    }

    public function getPresencePenalty(): null|float
    {
        return $this->presencePenalty;
    }

    /**
     * @param float|null $presencePenalty
     * @return MistralConversation
     */
    public function setPresencePenalty(?float $presencePenalty): MistralConversation
    {
        $this->presencePenalty = $presencePenalty;
        return $this;
    }

    public function getFrequencyPenalty(): null|float
    {
        return $this->frequencyPenalty;
    }

    /**
     * @param float|null $frequencyPenalty
     * @return MistralConversation
     */
    public function setFrequencyPenalty(?float $frequencyPenalty): MistralConversation
    {
        $this->frequencyPenalty = $frequencyPenalty;
        return $this;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     * @return MistralConversation
     */
    public function setTemperature(float $temperature): MistralConversation
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getTopP(): null|float
    {
        return $this->topP;
    }

    /**
     * @param float|null $topP
     * @return MistralConversation
     */
    public function setTopP(?float $topP): MistralConversation
    {
        $this->topP = $topP;
        return $this;
    }

    public function getMaxTokens(): null|int
    {
        return $this->maxTokens;
    }

    /**
     * @param int|null $maxTokens
     * @return MistralConversation
     */
    public function setMaxTokens(?int $maxTokens): MistralConversation
    {
        $this->maxTokens = $maxTokens;
        return $this;
    }

    public function getRandomSeed(): null|int
    {
        return $this->randomSeed;
    }

    /**
     * @param int|null $randomSeed
     * @return MistralConversation
     */
    public function setRandomSeed(?int $randomSeed): MistralConversation
    {
        $this->randomSeed = $randomSeed;
        return $this;
    }

    public function getPrediction(): null|array
    {
        return $this->prediction;
    }

    // Individual getters for completion args

    /**
     * @param array|null $prediction
     * @return MistralConversation
     */
    public function setPrediction(?array $prediction): MistralConversation
    {
        $this->prediction = $prediction;
        return $this;
    }

    public function getResponseFormat(): null|array
    {
        return $this->responseFormat;
    }

    /**
     * @param array|null $responseFormat
     * @return MistralConversation
     */
    public function setResponseFormat(?array $responseFormat): MistralConversation
    {
        $this->responseFormat = $responseFormat;
        return $this;
    }

    public function getToolChoice(): string
    {
        return $this->toolChoice;
    }

    /**
     * @param string $toolChoice
     * @return MistralConversation
     */
    public function setToolChoice(string $toolChoice): MistralConversation
    {
        $this->toolChoice = $toolChoice;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return MistralConversation
     */
    public function setName(?string $name): MistralConversation
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return MistralConversation
     */
    public function setDescription(?string $description): MistralConversation
    {
        $this->description = $description;
        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    /**
     * @param string|null $object
     * @return MistralConversation
     */
    public function setObject(?string $object): MistralConversation
    {
        $this->object = $object;
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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable $createdAt
     * @return MistralConversation
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): MistralConversation
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeImmutable $updatedAt
     * @return MistralConversation
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): MistralConversation
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}
