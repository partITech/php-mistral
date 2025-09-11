<?php

namespace Partitech\PhpMistral\Mcp;

use Exception;
use JsonSerializable;
use Mcp\Client\ClientSession;
use Mcp\Types\EmbeddedResource;
use Mcp\Types\PromptMessage;
use Mcp\Types\Role;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Exceptions\ToolExecutionException;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Resource;
use Partitech\PhpMistral\Tools\ToolCallFunction;
use Partitech\PhpMistral\Utils\File;
use Throwable;

class McpConfig implements JsonSerializable
{
    private array $servers = [];
    private array $variables = [];

    public function __construct(array $config, array $variables = [])
    {
        $this->variables = $variables;

        if (!isset($config['mcp']['servers']) || !is_array($config['mcp']['servers'])) {
            throw new Exception("Invalid MCP configuration: missing or malformed 'servers'");
        }

        foreach ($config['mcp']['servers'] as $name => $definition) {
            $this->servers[$name] = new McpServerConfig($name, $definition, $this->variables);
        }
    }

    /**
     * @return McpServerConfig[]
     */
    public function getServers(): array
    {
        return $this->servers;
    }

    public function getServer(string $name): ?McpServerConfig
    {
        return $this->servers[$name] ?? null;
    }

    public function getTools():array
    {
        $tools = [];
        foreach ($this->getServers() as $serverConfig) {
            $tools = array_merge($serverConfig->getTools(),$tools );
        }

        return $tools;
    }


    /**
     * @throws ToolExecutionException
     */
    public function handleToolCall(?ToolCallFunction $toolCallFunction): McpResult|null
    {
        // get server by function.
        $session = $this->getSessionByFunctionName($toolCallFunction->getName());
        if(is_null($session)){
            return null;
        }
        // execute tool
        try{
            $callToolResult = $session->callTool($toolCallFunction->getName(), $toolCallFunction->getArguments());
            $mcpResult = new McpResult();
            $mcpResult->setFunction($toolCallFunction);
            $mcpResult->setCallToolResult($callToolResult);
        }catch (Throwable $e){
            throw new ToolExecutionException($toolCallFunction->getName(), $e->getMessage());
        }

        return $mcpResult;
    }

    public function getPrompt(string $promptName, array $arguments=[], string $clientType = Client::TYPE_MISTRAL): Messages
    {
        $session = $this->getSessionByPromptName($promptName);
        $prompt = $session->getPrompt($promptName, $arguments);

        $messages = new Messages($clientType);
        /** @var PromptMessage $promptMessage */
        foreach($prompt->messages as $promptMessage){
            if($promptMessage->role->value === Role::USER->value && $promptMessage->content->type ==='text'){
                $messages->addUserMessage($promptMessage->content->text);
            }elseif($promptMessage->role->value === Role::ASSISTANT->value && $promptMessage->content->type ==='text'){
                $messages->addAssistantMessage($promptMessage->content->text);
            }elseif($promptMessage->role->value === Role::USER->value && $promptMessage->content->type ==='image'){
                $message = new Message(type: $clientType);
                $message->setRole(role: Messages::ROLE_USER);
                $message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: File::createTmpFile(data: $promptMessage->content->data, mimeType : $promptMessage->content->mimeType));
                $messages->addMessage($message);
            }elseif($promptMessage->role->value === Role::USER->value && $promptMessage->content instanceof EmbeddedResource){
                $messages->last()->setResource(Resource::fromJson(json_encode($promptMessage->content->resource)));
            }
        }

        return $messages;
    }

    public function getSessionByFunctionName(string $functionName):?ClientSession
    {
        foreach ($this->getServers() as $serverConfig) {
             if($serverConfig->hasTool($functionName)) {
                 $server = $serverConfig->setSession();
                 return $server->getSession();
             }
        }

        return null;
    }

    public function getSessionByPromptName(string $promptName):?ClientSession
    {
        foreach ($this->getServers() as $serverConfig) {
            if($serverConfig->hasPrompt($promptName)) {
                return $serverConfig->getSession();
            }
        }

        return null;
    }

    public function getToolsList():array
    {
        $tools = [];
        foreach ($this->getServers() as $serverConfig) {
            $tools = array_merge($serverConfig->getToolsList(), $tools);
        }
        return $tools;
    }

    public function getPromptsList():array
    {
        $prompts = [];
        foreach ($this->getServers() as $serverConfig) {
            $prompts = array_merge($serverConfig->getPromptsList(), $prompts);
        }
        return $prompts;
    }

    public function getPrompts():array
    {
        $prompts = [];
        foreach ($this->getServers() as $serverConfig) {
            foreach($serverConfig->getPrompts() as $prompt){
                $prompts[$prompt['prompt']['name']] = $prompt;
            }
        }

        return $prompts;
    }

    public function jsonSerialize(): array
    {
        return $this->getTools();
    }
}