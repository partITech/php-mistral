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

For this example, we will use the [filesystem](https://github.com/modelcontextprotocol/servers/tree/main/src/filesystem) MCP server from https://github.com/modelcontextprotocol github repository. You can find the built image on the [docker hub](https://hub.docker.com/r/mcp/filesystem)  

The main mcp server configuration. You need to declare a command and arguments to be able to use it.
For a webservice you will need to use the "url" declaration instead of command. See the documentation at [logiscape/mcp-sdk-php](https://github.com/logiscape/mcp-sdk-php) 
which is the main php package used for the MCP integration.

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
Now that your JSON config file is ok, Let’s see how to use it in practice.

1. Firstly, you need to create an MCPConfig object. Simply json_decode your main config file. You can create an array by hand if needed. But the main MCPConfig object is ready to accept a copy/paste of a large amount of config files provided by the mcp servers.
(This is the type of configuration used by Claude).

2. Create a client to select your inference provider
3. Generate your parameters. Feed the `tool` key with your McpConfig object. Your client will use this object and  create the json array needed to tell your LLM "hey this is the tools you should use". 
> [!TIP]
> Some models will have a lot of pain to use your tools. Specifically the small ones. Depending on your context size, you can add in your prompt the liste of tools the LLM can use. This can lead to better understanding on some case.
> Simply use the getList() method to get the entire list of tools configured by your servers, and pass a list in json format :
> ```php
> $toolList = json_encode($mcpConfig->getList());
> $messages = $this->client->getMessages()
>                  ->addSystemMessage('You are Qwen, created by Alibaba Cloud. You are a helpful assistant. You have access to the directory \/projects\/workspace\/ . here is the list of tools you can use :[AVAILABLE_TOOLS]' . $tools . '[/AVAILABLE_TOOLS]')
> ```
4. build your system and user messages
5. Use the chat() pethode as usual, or the new chatStream() method.

> [!CAUTION] 
> The chatStream() method is introduced for mcp recurtion. Due to the nature of PHP wiuth the `yield` generator function, we cannot mix yield and return a Response Object in the same method. As soon as use use the yield keyword the entire function definition is changed by PHP. 
> So, for a streamed response use the chatStream() method if you need MCP. 



> [!IMPORTANT] 
> Depending on your inference backend and the model you are using, the model **may fail to interpret tool responses**.
> This can result in an **infinite loop**, where the model keeps calling the same tool with the same arguments, over and over.
>
> This issue has been specifically observed with **Text Generation Inference (TGI)** from Hugging Face:
>
> * [TGI issue #2461 – Infinite tool calling loop](https://github.com/huggingface/text-generation-inference/issues/2461)
> * [TGI issue #2986 – Function calling never resolves](https://github.com/huggingface/text-generation-inference/issues/2986)
>
> However, **this behavior is not limited to TGI**. It can occur with **any inference engine or LLM**, depending on the model's reasoning capabilities and the structure of your tool responses.
>
> ✅ **Best practice**: always set a maximum recursion limit to avoid runaway loops.
>
> This is not only a technical safeguard — each tool recursion may trigger a new API call, causing **rapid budget consumption** if not controlled.
>
> ```php
> $client->setMcpMaxRecursion(7);
> ```
 

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

For a non-stream execution : 
```php

$response = $client->chat(messages: $messages, params: $params);

// Extract the message from the response.
echo $response->getMessage();
```
###
