## Sentiment analysis


There is no **guided_message** process with **Anthropic**. We can use the **tools** option to get this.
So we can use function calling process, and we have changed a bit the guided_json utility as for the others client to replicate the same as vllm
in order to smoothly switch between clients.


### php code

Firstly, we ill nee to create an ObjectSchema to lead the json outpout

```php
<?php

use KnpLabs\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\ObjectSchema;

class SentimentScoresFunctionSchema extends ObjectSchema
{
    public function __construct()
    {
        $this->addProperty(
            'positive_score',
            JsonSchema::create(
                'positive_score',
                'The positive sentiment score, ranging from 0.0 to 1.0.',
                [0.9],
                JsonSchema::number()
            ),
            true
        );

        $this->addProperty(
            'negative_score',
            JsonSchema::create(
                'negative_score',
                'The negative sentiment score, ranging from 0.0 to 1.0.',
                [0.1],
                JsonSchema::number()
            ),
            true
        );

        $this->addProperty(
            'neutral_score',
            JsonSchema::create(
                'neutral_score',
                'The neutral sentiment score, ranging from 0.0 to 1.0.',
                [0.5],
                JsonSchema::number()
            ),
            true
        );
    }

    public function getTitle(): string
    {
        return 'print_sentiment_scores';
    }

    public function getDescription(): string
    {
        return 'Prints the sentiment scores of a given text.';
    }

}

```

Then, use it in our guided_json parameter key.

```php
use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('ANTHROPIC_API_KEY');
$client = new AnthropicClient(apiKey: (string)$apiKey);


$messages = $client
    ->getMessages()
    ->addUserMessage("I'm a HUGE hater of pickles.  I actually despise pickles.  They are garbage.");

try {
    $chatResponse = $client->chat(
        $messages,
        [
            'model' => 'claude-3-7-sonnet-20250219',
            'temperature' => 0.2,
            'max_tokens' => 512,
            'guided_json' => new SentimentScoresFunctionSchema()
        ]
    );

    $guidedMessage = $chatResponse->getGuidedMessage();
    print_r($guidedMessage);

    $toolCallResponse = $chatResponse->getToolCalls();

    print_r($toolCallResponse[0]['function']['arguments']);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### result
```text
Array
(
    [positive_score] => 0.01
    [negative_score] => 0.92
    [neutral_score] => 0.07
)
```