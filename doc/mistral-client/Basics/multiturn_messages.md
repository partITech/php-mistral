
## Managing Messages in PhpMistral

This documentation explains how to use the `Messages` and `Message` objects in the **PhpMistral** library, which simplifies interactions with various generative AI services such as **Mistral**, **OpenAI**, **Anthropic**, **vLLM**, **Llama.cpp**, and others. It provides best practices, the rationale behind certain coding conventions, and guidance on how to structure effective multi-turn conversations.

## Why Use `Messages` and `Message` Objects?

Modern generative AI services typically require **conversation context** in the form of a list of structured messages. This list contains exchanges between different roles such as:
- `system`: defines behavior or general instructions for the model,
- `user`: represents messages sent by the user,
- `assistant`: responses from the AI,
- `tool`: integration with tools or intermediate results.

Each provider (Mistral, OpenAI, Anthropic, etc.) has **slight variations in the expected format** for these messages. The `Messages` and `Message` objects in **PhpMistral** encapsulate this formatting logic, providing a unified experience across different backends.

> [!IMPORTANT]
> The `Messages` and `Message` objects ensure **automatic compatibility with the selected service**, preventing formatting errors during API calls.

---

## Best Practices for Creating Conversations

### Recommended Approach

The best way to structure a conversation is to use the **methods provided by the client** (`MistralClient`, `OpenAIClient`, etc.), which automatically configure the message type:

```php
$client   = new MistralClient($apiKey);
$messages = $client->getMessages()
                   ->addSystemMessage('You are a gentle bot who respond like a pirate')
                   ->addUserMessage('What is the best French cheese?');

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'mistral-3b-latest',
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 250,
            'safe_prompt' => false,
            'random_seed' => null
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

> [!TIP]
> This approach ensures that the **service type** (Mistral, OpenAI, etc.) is properly accounted for during message creation, guaranteeing the correct format.

---

### Discouraged Approach

Creating `Messages` objects **without specifying the client type** might work but **breaks encapsulation** and risks omitting service-specific requirements:

```php
$client = new MistralClient($apiKey);
$messages = new Messages(); // Discouraged: no type specified!
$messages->addUserMessage('What is the best French cheese?');
```

> [!CAUTION]
> This method does not define the `type` (Mistral, OpenAI, etc.), which may lead to **format errors** when sending requests to the service.

---

### Valid Alternative (More Verbose)

For advanced use cases where **greater control** over each `Message` is needed:

```php
$client   = new MistralClient($apiKey);
$messages = new Messages(type: Client::TYPE_MISTRAL);

$message = new Message(type: Client::TYPE_MISTRAL);
$message->setRole(Messages::ROLE_SYSTEM);
$message->setContent('You are a gentle bot. Respond like a pirate');
$messages->addMessage($message);

$message = new Message(type: Client::TYPE_MISTRAL);
$message->setRole(Messages::ROLE_USER);
$message->setContent('What is the best French cheese?');
$messages->addMessage($message);
```

This approach provides **full control** over individual messages but is **more verbose and complex**.

---

## Internal Mechanics of `Messages` and `Message`

### Service Type (`type`)

The `type` attribute is crucial for adapting the **message structure** to the target service:

| Client Type           | PHP Constant            |
|-----------------------|-------------------------|
| Mistral               | `Client::TYPE_MISTRAL`  |
| OpenAI                | `Client::TYPE_OPENAI`   |
| Anthropic             | `Client::TYPE_ANTHROPIC`|
| X.AI                  | `Client::TYPE_XAI`      |
| Llama.cpp             | `Client::TYPE_LLAMACPP` |
| vLLM                  | `Client::TYPE_VLLM`     |

Each provider has **specific requirements** (e.g., `tool_calls` for OpenAI or image formatting for Anthropic), and the `type` ensures **automatic adjustment** of the message format.

---

## Advanced Message Manipulation

You can directly access the underlying `ArrayObject` containing the messages for custom operations:

```php
$messages = $client->getMessages();
$arrayMessages = $messages->getMessages(); // ArrayObject

foreach ($arrayMessages as $message) {
    // Manipulate individual messages
}
```

---

## Why Prefer Client-Based Message Creation?

1. **Full encapsulation**: the client manages the message format and type automatically.
2. **Guaranteed compatibility**: the message structure always aligns with the target service (Mistral, OpenAI, etc.).
3. **Error reduction**: no risk of sending malformed messages that might be rejected by the API.
4. **Simplified maintenance**: if the API format changes, the library can adapt without requiring code changes on your end.

> [!WARNING]
> Avoid creating `Messages` or `Message` objects **without specifying a type**, as this can cause compatibility issues with certain services.

---

## Special Cases: Multimodality and Tool Integration

The message system also supports **multimodal content** (images, audio, documents) and **tool integration** (tool calls).

### Example: Adding an Image

```php
$message = $client->newMessage();
$message->setRole(Messages::ROLE_USER);
$message->addContent(Message::MESSAGE_TYPE_IMAGE_URL, 'https://example.com/image.jpg');
```

### Example: Adding a Tool Result

```php
$messages->addToolMessage(
    name: 'weather',
    content: ['temperature' => '22°C'],
    toolCallId: 'abc-123'
);
```

> [!NOTE]
> These features are **automatically adapted** to the client type (e.g., documents are formatted differently for **Anthropic**).

---

## Conclusion

Using the `Messages` and `Message` objects **via the client** is the safest and most efficient way to build conversations tailored to different AI providers. This approach ensures compatibility, reduces errors, and simplifies maintenance.

Follow the recommendations in this guide to ensure robust and reliable integrations with AI services.
