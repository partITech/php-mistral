## Pdf
### Document Base64
#### php code
```php
use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('ANTHROPIC_API_KEY');

$client = new AnthropicClient(apiKey: (string)$apiKey);
$file = $client->downloadToTmp('https://assets.anthropic.com/m/1cd9d098ac3e6467/original/Claude-3-Model-Card-October-Addendum.pdf');

$message = $client
    ->newMessage()
    ->setRole('user')
    ->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'What are the key findings in this document?')
    ->addContent(type: Message::MESSAGE_TYPE_DOCUMENT_BASE64, content: realpath($file));
$messages = new Messages();
$messages->addMessage($message);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'claude-3-5-haiku-20241022',
            'max_tokens' => 1024
        ]
    );
    print($result->getMessage());
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### result
```text
Based on the document, here are the key findings for the Claude 3.5 Sonnet and Claude 3.5 Haiku models:

1. New Capabilities:
- Claude 3.5 Sonnet introduces a new computer use capability, allowing it to:
  - Interpret screenshots
  - Generate GUI computer commands
  - Navigate websites and web applications
  - Interact with user interfaces
  - Complete multi-step processes

2. Performance Improvements:
- Achieved state-of-the-art results in several domains:
  - SWE-bench Verified: 49.0% pass rate (highest to date)
  - TAU-bench: 69.2% success in retail customer service, 46.0% in airline domain
  - Agentic coding tasks: 78% problem-solving success
  - Vision capabilities: Top performance in mathematical reasoning, chart interpretation, and document analysis

3. Human Feedback Evaluations:
- Outperformed previous models in:
  - Document analysis (61% win rate)
  - Visual understanding (57% win rate)
  - Creative writing (58% win rate)
  - Coding (52% win rate)
  - Following precise instructions (51% win rate)

4. Safety Considerations:
- Underwent extensive safety evaluations
- Classified under AI Safety Level (ASL)-2
- Improved harm reduction compared to previous models
- No identified catastrophic risks

5. Knowledge Cutoff:
- Claude 3.5 Sonnet: April 2024
- Claude 3.5 Haiku: July 2024

The models demonstrate significant advances in reasoning, coding, visual processing, and task completion capabilities.
```


### Image URL message
#### php code
```php
$client = new AnthropicClient(apiKey: (string)$apiKey);

$message = $client
    ->newMessage()
    ->setRole('user')
    ->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'What are the key findings in this document?')
    ->addContent(type: Message::MESSAGE_TYPE_DOCUMENT_URL, content: 'https://assets.anthropic.com/m/1cd9d098ac3e6467/original/Claude-3-Model-Card-October-Addendum.pdf');
$messages = $client->getMessages()->addMessage($message);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'claude-3-5-haiku-20241022',
            'max_tokens' => 1024
        ]
    );
    print($result->getMessage());
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### result
```text

```