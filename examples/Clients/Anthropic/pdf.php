<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('ANTHROPIC_API_KEY');

$client = new AnthropicClient(apiKey: (string)$apiKey);
$file = $client->downloadToTmp('https://assets.anthropic.com/m/1cd9d098ac3e6467/original/Claude-3-Model-Card-October-Addendum.pdf');

$message = $client->newMessage()->setRole('user')->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'What are the key findings in this document?')->addContent(type: Message::MESSAGE_TYPE_DOCUMENT_BASE64, content: realpath($file));
$messages = new Messages();
$messages->addMessage($message);

try {
    $result = $client->chat($messages, ['model' => 'claude-3-5-haiku-20241022', 'max_tokens' => 1024,]);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());

echo PHP_EOL . "____________________________________________________________" . PHP_EOL;

$message = new Message(type: Message::TYPE_ANTHROPIC);
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'What are the key findings in this document?');
$message->addContent(type: Message::MESSAGE_TYPE_DOCUMENT_URL, content: 'https://assets.anthropic.com/m/1cd9d098ac3e6467/original/Claude-3-Model-Card-October-Addendum.pdf');
$messages = new Messages();
$messages->addMessage($message);

try {
    $result = $client->chat($messages, ['model' => 'claude-3-5-haiku-20241022', 'max_tokens' => 1024,]);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());

/**
 * # Summary of Claude 3.5 Haiku and Upgraded Claude 3.5 Sonnet
 *
 * This model card addendum describes two new models from Anthropic: an upgraded version of Claude 3.5 Sonnet and the new Claude 3.5 Haiku. Here are the key points:
 *
 * ## Key Capabilities and Improvements
 *
 * ### Upgraded Claude 3.5 Sonnet:
 * - Introduces computer use capability: can interpret GUI screenshots and generate appropriate tool calls
 * - Can navigate websites, interact with interfaces, and complete multi-step processes
 * - Sets new state-of-the-art standards in agentic coding (SWE-bench), task completion (TAU-bench), and computer use (OSWorld)
 * - Achieves 14.9% success rate on OSWorld tasks (22% with increased interaction steps)
 * - Knowledge cutoff: April 2024
 *
 * ### Claude 3.5 Haiku:
 * - Smaller model that performs comparably to the original Claude 3.5 Sonnet in many areas
 * - Strong at reasoning and instruction following
 * - Will initially launch as a text-only model
 * - Knowledge cutoff: July 2024
 *
 * ## Performance Highlights
 *
 * ### Tool Use & Agentic Tasks:
 * - Upgraded Sonnet: 49.0% on SWE-bench Verified (vs. 33.4% for original)
 * - Haiku: 40.6% on SWE-bench Verified (better than original Sonnet)
 * - On TAU-bench, Upgraded Sonnet achieves 69.2% for retail and 46.0% for airline domains
 *
 * ### Reasoning & Coding:
 * - Both models show improvements in mathematical reasoning, coding, and general problem-solving
 * - Upgraded Sonnet achieves 78.3% on MATH problems and 93.7% on HumanEval
 * - Haiku achieves 69.2% on MATH and 88.1% on HumanEval
 *
 * ### Vision Capabilities (Upgraded Sonnet):
 * - State-of-the-art performance on multimodal evaluations
 * - 70.7% on MathVista, 95.3% on AI2D, 90.8% on ChartQA
 *
 * ## Safety Evaluations
 *
 * - Both models underwent extensive safety evaluations for biological, cybersecurity, and autonomous behavior risks
 * - Testing included multimodal red-team exercises and specific evaluations for computer use
 * - Pre-deployment testing conducted with US AI Safety Institute and UK AI Safety Institute
 * - Trust & Safety evaluations across 14 policy areas in 6 languages
 * - Enhanced ability to recognize and resist prompt injection attempts
 *
 * The document highlights that while the computer use capability represents a significant advancement, it's still in early development stages and safety remains a priority.
 */