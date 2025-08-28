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

PHP-Mistral supports MCP through its **Function Calling** mechanism (see [Basics/function\_calling.md](Basics/function_calling.md)). Each 'tool' is declared to allow the model to dynamically select which function to invoke, along with its arguments. .

For this example, we will use the [filesystem](https://github.com/modelcontextprotocol/servers/tree/main/src/filesystem) MCP server from https://github.com/modelcontextprotocol GitHub repository. You can find the built image on the [docker hub](https://hub.docker.com/r/mcp/filesystem)  

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
Once your JSON config is configured properly, the following steps guide you through practical implementation.

1. Firstly, you need to create an MCPConfig object. Simply json_decode your main config file. You can create an array by hand if needed. But the main MCPConfig object is ready to accept a copy/paste of a large amount of config files provided by the mcp servers.
(This is the type of configuration used by Claude).

2. Create a client to select your inference provider
3. Generate your parameters. Feed the `tool` key with your McpConfig object. Your client will use this object and create the JSON array needed to tell your LLM "Hey this is the tools you should use". 
> [!TIP]
> Some models will have a lot of pain to use your tools. Specifically the small ones. Depending on your context size, you can add in your prompt the list of tools the LLM can use. This can improve understanding in certain cases.
> Simply use the getToolsList() method to get the entire list of tools configured by your servers, and pass a list in JSON format :
> ```php
> $toolList = json_encode($mcpConfig->getToolsList());
> $messages = $this->client->getMessages()
>                  ->addSystemMessage('You are Qwen, created by Alibaba Cloud. You are a helpful assistant. You have access to the directory /projects/workspace/ . here is the list of tools you can use : ' . $tools . '')
> ```
4. build your system and user messages
5. Use the chat() method as usual, or the new chatStream() method.

> [!CAUTION] 
> The chatStream() method is introduced for mcp recursion. Due to the nature of PHP with the `yield` generator function, we cannot mix yield and return a Response Object in the same method. As soon as use use the yield keyword the entire function definition is changed by PHP. 
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
use Partitech\PhpMistral\Clients\Mistral\MistralClient;

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
### Using Prompt capabilities with MCP

List the prompts : 

```php

$prompts = $mcpConfig->getPrompts();
```

```shell
array(3) {
  [0]=>
  string(13) "simple_prompt"
  [1]=>
  string(14) "complex_prompt"
  [2]=>
  string(15) "resource_prompt"
}
```

Get the prompts definitions : 


```php
$prompts = $mcpConfig->getPrompts();
var_dump($prompts);
```

```shell
array(3) {
  ["simple_prompt"]=>
  array(2) {
    ["type"]=>
    string(6) "prompt"
    ["prompt"]=>
    array(3) {
      ["description"]=>
      string(26) "A prompt without arguments"
      ["name"]=>
      string(13) "simple_prompt"
      ["parameters"]=>
      array(0) {
      }
    }
  }
  ["complex_prompt"]=>
  array(2) {
    ["type"]=>
    string(6) "prompt"
    ["prompt"]=>
    array(3) {
      ["description"]=>
      string(23) "A prompt with arguments"
      ["name"]=>
      string(14) "complex_prompt"
      ["parameters"]=>
      array(2) {
        [0]=>
        object(Mcp\Types\PromptArgument)#89 (4) {
          ["name"]=>
          string(11) "temperature"
          ["description"]=>
          string(19) "Temperature setting"
          ["required"]=>
          bool(true)
          ["extraFields":protected]=>
          array(0) {
          }
        }
        [1]=>
        object(Mcp\Types\PromptArgument)#90 (4) {
          ["name"]=>
          string(5) "style"
          ["description"]=>
          string(12) "Output style"
          ["required"]=>
          bool(false)
          ["extraFields":protected]=>
          array(0) {
          }
        }
      }
    }
  }
  ["resource_prompt"]=>
  array(2) {
    ["type"]=>
    string(6) "prompt"
    ["prompt"]=>
    array(3) {
      ["description"]=>
      string(53) "A prompt that includes an embedded resource reference"
      ["name"]=>
      string(15) "resource_prompt"
      ["parameters"]=>
      array(1) {
        [0]=>
        object(Mcp\Types\PromptArgument)#92 (4) {
          ["name"]=>
          string(10) "resourceId"
          ["description"]=>
          string(30) "Resource ID to include (1-100)"
          ["required"]=>
          bool(true)
          ["extraFields":protected]=>
          array(0) {
          }
        }
      }
    }
  }
}
```

And finaly use the prompt : 

`$mcpConfig->getPrompts()` will return a `Messages` with a list of `Message` object according to the MCP server response.

If the MCP server reponds with a `resource` object, you can access it with the `getResource()` method.

```php
$ressourcePrompt = $mcpConfig->getPrompt('resource_prompt', ['resourceId' =>  '55']);
var_dump($ressourcePrompt);
var_dump($ressourcePrompt->getResource());
```

```shell
object(Partitech\PhpMistral\Messages)#65 (3) {
  ["messages":"Partitech\PhpMistral\Messages":private]=>
  object(ArrayObject)#68 (1) {
    ["storage":"ArrayObject":private]=>
    array(1) {
      [0]=>
      object(Partitech\PhpMistral\Message)#67 (16) {
        ["urlAsArray":"Partitech\PhpMistral\Message":private]=>
        bool(false)
        ["role":"Partitech\PhpMistral\Message":private]=>
        string(4) "user"
        ["id":"Partitech\PhpMistral\Message":private]=>
        NULL
        ["content":"Partitech\PhpMistral\Message":private]=>
        string(72) "This prompt includes Resource 55. Please analyze the following resource:"
        ["chunk":"Partitech\PhpMistral\Message":private]=>
        NULL
        ["toolCalls":"Partitech\PhpMistral\Message":private]=>
        object(Partitech\PhpMistral\Tools\ToolCallCollection)#71 (1) {
          ["calls":"Partitech\PhpMistral\Tools\ToolCallCollection":private]=>
          array(0) {
          }
        }
        ["partialToolCalls":"Partitech\PhpMistral\Message":private]=>
        array(0) {
        }
        ["stopReason":"Partitech\PhpMistral\Message":private]=>
        NULL
        ["toolCallId":"Partitech\PhpMistral\Message":private]=>
        NULL
        ["name":"Partitech\PhpMistral\Message":private]=>
        NULL
        ["clientType":"Partitech\PhpMistral\Message":private]=>
        string(7) "Mistral"
        ["createdAt":"Partitech\PhpMistral\Message":private]=>
        NULL
        ["completedAt":"Partitech\PhpMistral\Message":private]=>
        NULL
        ["type":"Partitech\PhpMistral\Message":private]=>
        NULL
        ["references":"Partitech\PhpMistral\Message":private]=>
        array(0) {
        }
        ["resource":"Partitech\PhpMistral\Message":private]=>
        object(Partitech\PhpMistral\Resource)#73 (4) {
          ["uri":"Partitech\PhpMistral\Resource":private]=>
          string(25) "test://static/resource/55"
          ["mimeType":"Partitech\PhpMistral\Resource":private]=>
          string(10) "text/plain"
          ["extraFields":"Partitech\PhpMistral\Resource":private]=>
          array(0) {
          }
          ["text":"Partitech\PhpMistral\Resource":private]=>
          string(41) "Resource 55: This is a plaintext resource"
        }
      }
    }
  }
  ["document":"Partitech\PhpMistral\Messages":private]=>
  NULL
  ["clientType":"Partitech\PhpMistral\Messages":private]=>
  string(7) "Mistral"
}
```

```shell
object(Partitech\PhpMistral\Resource)#73 (4) {
  ["uri":"Partitech\PhpMistral\Resource":private]=>
  string(25) "test://static/resource/55"
  ["mimeType":"Partitech\PhpMistral\Resource":private]=>
  string(10) "text/plain"
  ["extraFields":"Partitech\PhpMistral\Resource":private]=>
  array(0) {
  }
  ["text":"Partitech\PhpMistral\Resource":private]=>
  string(41) "Resource 55: This is a plaintext resource"
}
```

To get the message compatible with your server you can add a third parameters to your getPrompt() method :
```php
$ressourcePrompt = $mcpConfig->getPrompt( promptName: 'resource_prompt', 
                                          arguments:  ['resourceId' =>  '55'], 
                                          clientType: Client::TYPE_MISTRAL);
```
