<?php

namespace Partitech\PhpMistral\Mcp;

use Exception;
use JsonSerializable;
use Mcp\Client\ClientSession;
use Partitech\PhpMistral\Exceptions\ToolExecutionException;
use Partitech\PhpMistral\Tools\ToolCallFunction;
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

    public function getSessionByFunctionName(string $functionName):?ClientSession
    {
        foreach ($this->getServers() as $serverConfig) {
             if($serverConfig->hasTool($functionName)) {
                 return $serverConfig->getSession();
             }
        }

        return null;
    }

    public function getList():array
    {
        $tools = [];
        foreach ($this->getServers() as $serverConfig) {
            $tools = array_merge($serverConfig->getList(), $tools );
        }
        return $tools;
    }

    public function jsonSerialize(): array
    {
        return $this->getTools();
    }
}