## History of the Model Context Protocol (MCP)

The Model Context Protocol (MCP) was introduced by Anthropic on November 25, 2024 as an open standard to unify the interface between large language models and external data sources (web APIs, databases, file systems, etc.) [1][2]. Within months, major industry players joined the initiative:

* **March 2025:** OpenAI announced MCP support for its Agents SDK, ChatGPT desktop app, and the Responses API [1].
* **April 2025:** Google DeepMind slated MCP integration in its upcoming Gemini models [1].

## Key Benefits

* **Interoperability & Standardization**
  MCP acts like a “universal USB-C port” for AI: replacing bespoke integrations with a single, consistent format, reducing development time and minimizing integration errors [1][3].
* **Extensibility**
  Official SDKs (Python, TypeScript, C#, Java) and a plug-and-play architecture let you deploy or author custom MCP servers that remain fully compatible with the broader ecosystem [2].
* **Built-in Security**
  The protocol enforces strict server-side access controls (resource quotas, filtering, API-key protection) without exposing sensitive credentials to LLM providers [1].

## Why It’s Revolutionary

1. **Advanced Autonomous Agents**
   LLMs can seamlessly orchestrate complex action chains (read/write files, query databases, drive browsers), paving the way for genuine autonomous assistants [1][3].
2. **Unified Ecosystem**
   By replacing multiple proprietary integrations with one open standard, MCP breaks down data silos and fosters cross-platform collaboration.
3. **Rapid Industry Adoption**
   Backing from Anthropic, OpenAI, Google, Microsoft Copilot Studio, and more underscores MCP’s potential to become the de facto standard for AI integration in existing workflows.

---

## Integration with PHP-Mistral

PHP-Mistral supports MCP through its **Function Calling** mechanism (see [Basics/function\_calling.md](Basics/function_calling.md)). Each “tool” is declared so the model can dynamically choose which function to invoke and with what arguments.


```json
{
  "mcp": {
    "servers": {
      "filesystem": {
        "command": "docker",
        "args": [
          "run",
          "-i",
          "--rm",
          "--user", "${CURRENT_UID}:${CURRENT_GID}",
          "--mount", "type=bind,src=${workspaceFolder},dst=/projects/workspace",
          "mcp/filesystem",
          "/projects"
        ]
      }
    }
  }
}
```


```php
use Partitech\PhpMistral\Mcp\McpConfig;
use Partitech\PhpMistral\Clients\MistralClient;

// 1. Retrieve UID/GID
$currentUid = posix_getuid();
$currentGid = posix_getgid();

// 2. Load MCP configuration
$configArray = json_decode(file_get_contents('mcp_config.json'), true);
$mcpConfig   = new McpConfig(
    $configArray,
    [
        'workspaceFolder' => './my/secured/directory',
        'CURRENT_UID'     => $currentUid,
        'CURRENT_GID'     => $currentGid,
    ]
);

// 3. Initialize client
$apiKey    = getenv('MISTRAL_API_KEY');
$chatModel = getenv('MISTRAL_CHAT_MODEL');
$client    = new MistralClient(apiKey: $apiKey);
$client->setMcpMaxRecursion(7); // Prevents infinite recursion

// 4. Generation parameters
$params = [
    'model'              => $chatModel,
    'temperature'        => 0.1,
    'top_p'              => 0.9,
    'top_k'              => 40,
    'max_tokens'         => 1024,
    'repetition_penalty' => 1.2,
    'tools'              => $mcpConfig,
    'tool_choice'        => MistralClient::TOOL_CHOICE_AUTO,
];

// 5. Build messages
$messages = $client->getMessages();
$messages->addSystemMessage('Accessing directory: /projects/workspace/');
$messages->addUserMessage(<<<'PROMPT'
1. Read the file /projects/workspace/test.md.
2. Create /projects/workspace/translated if it does not exist.
3. Generate one file per language:
   - test_en.md (English)
   - test_fr.md (French)
4. Repeat until all files are created.
5. Report the size in bytes of each generated file.
PROMPT
);

// 6. Stream execution
foreach ($client->chatStream(messages: $messages, params: $params) as $chunk) {
    echo $chunk->getChunk();
}
```

For a non stream execution : 
```php

$response = $client->chat(messages: $messages, params: $params);

// Extract the message from the response.
echo $response->getMessage();
```
###