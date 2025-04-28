## Guided JSON

**Guided JSON** allows you to enforce structured outputs from the language model by defining a JSON schema. This ensures that the model’s response follows a predictable and machine-readable format, which is particularly useful for applications requiring complex structured data such as APIs, analytics, or reporting systems.

> [!NOTE]  
> A well-typed, richly described schema acts as **both** a data contract **and** a verbal guide for the model. Vague or under-specified properties will almost always produce lower-quality, less-relevant data.

---

### Supported Clients

| Provider                  | Client Instantiation Example                                                  |
|---------------------------|-------------------------------------------------------------------------------|
| **Mistral Platform**      | `$client = new MistralClient($apiKey);`                                       |
| **Anthropic**             | `$client = new AnthropicClient(apiKey: $apiKey);`                             |
| **Llama.cpp**             | `$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);`   |
| **Hugging Face TGI**      | `$client = new TgiClient(apiKey: $apiKey, url: $tgiUrl);`                     |
| **Hugging Face Inference**| `$client = new HuggingFaceClient(apiKey: $apiKey, provider: 'hf-inference');` |
| **Ollama**                | `$client = new OllamaClient(url: $ollamaUrl);`                                |
| **vLLM**                  | `$client = new VllmClient(apiKey: $apiKey, url: $url);`                       |
| **xAI**                   | `$client = new XAiClient(apiKey: $apiKey);`                                   |

> [!WARNING]  
> Each backend handles JSON/function-calling differently. **php-mistral** hides these differences: it reformats your schema internally so you can write **one** schema and use it everywhere.

* **Mistral & vLLM** – accept raw JSON function calls that map closely to the schema.  
* **Hugging Face Inference / TGI** – very similar to Mistral/vLLM but require minor field renaming; handled automatically.  
* **Anthropic (Claude)** – no native JSON mode; `php-mistral` injects your schema into the **`tools`** parameter and converts the response back.  
* **Ollama, Llama.cpp, xAI** – each has its own schema / tool syntax; the library adapts the payload behind the scenes.

You only author the schema once—**php-mistral** does the backend-specific heavy lifting.

---

### Building Schemas with **KnpLabs\JsonSchema**

The **KnpLabs\JsonSchema** library is used to describe JSON schemas in PHP.

| Concept | Why it matters |
|---------|----------------|
| **Fine-grained properties** | Every property must have an explicit *type*, *description*, and ideally *examples*. These cues teach the model **what** to output and **how** to interpret the data. |
| **Descriptive metadata** | The `title`, `description`, and `examples` of both the schema and its properties give extra context; richer metadata → more accurate generations. |
| **Structures & types** | Supports primitive types, arrays/collections, and nested objects to model virtually any JSON shape. |

`ObjectSchema` is the workhorse for assembling objects, while `Partitech\PhpMistral\JsonSchema\JsonSchema` extends the base class to ensure provider compatibility (e.g., dropping `minLength` for Mistral).

```php
namespace Partitech\PhpMistral\JsonSchema;

class JsonSchema extends \KnpLabs\JsonSchema\JsonSchema
{
    public static function text(): array
    {
        return [
            'type' => 'string',  // compatible with all back-ends
        ];
    }
}
```

---

### Example 1 • Simple List Schema
```php
use KnpLabs\JsonSchema\ObjectSchema;
use Partitech\PhpMistral\JsonSchema\JsonSchema;

class SimpleListSchema extends ObjectSchema
{
    public function __construct()
    {
        $item = JsonSchema::create(
            'List of items',
            'Analyze a query and generate a list of items.',
            ['200g sugar'],
            JsonSchema::text()
        );
        $this->addProperty(
            'datas',
            JsonSchema::collection($item),
            true
        );
    }
}
```

---

### Example 2 • Sentiment Analysis Schema
```php
use KnpLabs\JsonSchema\ObjectSchema;
use KnpLabs\JsonSchema\JsonSchema;

class SentimentScoresFunctionSchema extends ObjectSchema
{
    public function __construct()
    {
        foreach (['positive', 'negative', 'neutral'] as $sentiment) {
            $this->addProperty(
                "{$sentiment}_score",
                JsonSchema::create(
                    "{$sentiment}_score",
                    "The {$sentiment} sentiment score, from 0.0 to 1.0.",
                    [0.5],
                    JsonSchema::number()
                ),
                true
            );
        }
    }

    public function getTitle(): string       { return 'print_sentiment_scores'; }
    public function getDescription(): string { return 'Prints the sentiment scores of a given text.'; }
}
```

Expected output:
```json
{
  "positive_score": 0.85,
  "negative_score": 0.05,
  "neutral_score": 0.10
}
```

---

### Usage Example (any backend)
```php
$client   = new MistralClient(apiKey: (string) $apiKey, url: $url); // swap client class to switch backend
$messages = $client->newMessages()
                   ->addUserMessage('Analyze this review and return sentiment scores as JSON.');

$params = [
    'model'       => 'ministral-8b-latest',
    'top_p'       => 1,
    'seed'        => 157,
    'guided_json' => new SentimentScoresFunctionSchema(),
];

$resp = $client->chat($messages, $params);

print_r($resp->getGuidedMessage());      // structured stdClass
print_r($resp->getMessage()); // raw JSON text
```

---

> [!IMPORTANT]  
> Behind the scenes, **php-mistral** converts your schema to the correct backend-specific format (`tools`, `functions`, raw JSON mode, etc.). You focus on **what** you need; the library handles **how** to ask.

> [!CAUTION]  
> If the model output doesn’t match the schema, parsing may fail. Refine your property descriptions and types to guide the model more precisely.
