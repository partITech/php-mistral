## Multimodal
The Claude 3 family of models comes with new vision capabilities that allow Claude to understand and analyze images, opening up exciting possibilities for multimodal interaction.

This guide describes how to work with images in Claude, including best practices, code examples, and limitations to keep in mind.

### Before you upload

#### Basics and Limits

You can include multiple images in a single request (up to **20** for claude.ai and **100** for API requests). Claude will analyze all provided images when formulating its response. This can be helpful for comparing or contrasting images.

- If you submit an image larger than **8000x8000 px**, it will be rejected.
- If you submit more than **20 images** in one API request, the per-image size limit is **2000x2000 px**.

---

#### Evaluate image size

For optimal performance, we recommend resizing images before uploading if they are too large.

- If your image’s long edge is more than **1568 pixels**, or your image exceeds approximately **1,600 tokens**, it will first be scaled down (preserving aspect ratio) until it’s within the size limits.

> [!NOTE]
> **Note:** If your input image is too large and needs to be resized, it will increase the latency of time-to-first-token without improving model performance.

Very small images (under **200 pixels** on any given edge) may degrade performance.

### Base64 message
#### php code
```php
use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('ANTHROPIC_API_KEY');
$client = new AnthropicClient(apiKey: (string)$apiKey);

$message = $client->newMessage()
    ->setRole('user')
    ->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'What is in this image?')
    ->addContent(type: Message::MESSAGE_TYPE_BASE64, content: realpath('./../../medias/pixtral_image_example_charts.jpeg'));
$messages = $client
    ->getMessages()
    ->addMessage($message);

try {
        $result = $client->chat(
            $messages, 
            [
                'model' => 'claude-3-7-sonnet-20250219', 
                'max_tokens' => 1024
            ]
        );
    print($result->getMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


```

#### result
```text
The image presents a statistical comparison highlighting France's social divide between disadvantaged areas and the country as a whole.

Key findings from the chart include:

- Working class representation: 33.5% in disadvantaged areas versus 14.5% nationally
- Unemployment: 18.1% in disadvantaged areas compared to 7.3% nationally
- Youth disengagement: 25.2% of 16-25 year-olds in disadvantaged areas are neither in school nor employed, versus 12.9% nationally
- Median monthly income: €1,168 in disadvantaged areas versus €1,822 nationally
- Poverty rate: 43.3% in disadvantaged areas compared to 15.5% nationally
- Overcrowded housing: 22.0% of households in disadvantaged areas versus 8.7% nationally

The chart defines disadvantaged areas as those with average per-capita income below €11,250/year, noting that in 2022, 5.4 million people (8% of France's population) lived in 1,514 such areas across 859 municipalities.

This visualization effectively demonstrates the significant socioeconomic disparities that exist within France, with disadvantaged areas facing substantially higher rates of poverty, unemployment, and housing challenges compared to national averages.

```


### Image URL message
#### php code
```php
use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

$apiKey = getenv('ANTHROPIC_API_KEY');
$client = new AnthropicClient(apiKey: (string)$apiKey);

$message = $client
    ->newMessage()
    ->setRole('user')
    ->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'What is in this image?')
    ->addContent(type: Message::MESSAGE_TYPE_IMAGE_URL, content: 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg');
$messages = $client->getMessages();
$messages->addMessage($message);

try {
    $result = $client->chat($messages, ['model' => 'claude-3-7-sonnet-20250219', 'max_tokens' => 1024,]);
    print($result->getMessage());

} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

#### result
```text
The image shows three people jogging together along a green, nature-filled path. They appear to be enjoying a workout in a lush outdoor setting with trees and vegetation surrounding the trail. The runners are wearing athletic clothing - one in a gray shirt with black shorts, another in a bright yellow tank top with black shorts, and the third in a pink top with black leggings. They seem to be running at a comfortable pace, and the scene conveys a sense of health, fitness, and outdoor activity. The natural environment looks bright and vibrant, making it an appealing setting for outdoor exercise.
```