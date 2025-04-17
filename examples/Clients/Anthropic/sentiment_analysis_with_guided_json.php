<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';
require_once './SentimentScoresFunctionSchema.php';

// from http://github.com/anthropics/courses/blob/master/tool_use/03_structured_outputs.ipynb
use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('ANTHROPIC_API_KEY');

$client = new AnthropicClient(apiKey: (string)$apiKey);

// there is no guided_message process with anthropic. We can use the tools option to get this.
// So we can use function calling process, and we have changed a bit the guided_json utility as for the others client to replicate the same as vllm
// in order to smoothly switch between clients.

$messages = new Messages();
$messages->addUserMessage("I'm a HUGE hater of pickles.  I actually despise pickles.  They are garbage.");

$params = ['model' => 'claude-3-7-sonnet-20250219', 'temperature' => 0.2, 'max_tokens' => 512, 'guided_json' => new SentimentScoresFunctionSchema()];

try {
    $chatResponse = $client->chat($messages, $params);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
$guidedMessage = $chatResponse->getGuidedMessage();
print_r($guidedMessage);

$toolCallResponse = $chatResponse->getToolCalls();

print_r($toolCallResponse[0]['function']['arguments']);

//Array
//(
//    [positive_score] => 0.01
//    [negative_score] => 0.92
//    [neutral_score] => 0.07
//)

