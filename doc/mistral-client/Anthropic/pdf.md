## Pdf
Process PDFs with Claude. Extract text, analyze charts, and understand visual content from your documents.

You can now ask Claude about any text, pictures, charts, and tables in PDFs you provide. Some sample use cases:

- Analyzing financial reports and understanding charts/tables
- Extracting key information from legal documents
- Translation assistance for documents
- Converting document information into structured formats

### Check PDF requirements

Claude works with any standard PDF. However, you should ensure your request size meets these requirements when using PDF support:

| Requirement              | Limit                          |
|--------------------------|--------------------------------|
| Maximum request size     | 32MB                           |
| Maximum pages per request| 100                            |
| Format                   | Standard PDF (no passwords/encryption) |

> [!NOTE]
> Please note that both limits are on the entire request payload, including any other content sent alongside PDFs.

Since PDF support relies on Claude’s vision capabilities, it is subject to the same limitations and considerations as other vision tasks.


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

## Additional Resources
[https://docs.anthropic.com/en/docs/build-with-claude/pdf-support](https://docs.anthropic.com/en/docs/build-with-claude/pdf-support)