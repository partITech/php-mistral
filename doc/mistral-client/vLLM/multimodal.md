# Multimodal Chat with Images, Videos, and Audio

The example covers:

- Image captioning and analysis.
- Video description (via URL or base64).
- Audio transcription and summarization (via URL or base64).

> [!IMPORTANT]
> Multimodal support depends on the model capabilities. Ensure the model you select can process the desired media type (image, video, audio).

---

## Image Analysis

Send **multiple images** (URLs and local base64) alongside text instructions for detailed analysis.

```php
use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;

$client = new VllmClient(apiKey: $apiKey, url: $url);

$message = $client->newMessage();
$message->setRole('user');
$message->addContent(Message::MESSAGE_TYPE_TEXT, 'Proceed step by step. For each media, describe it carefully.');
$message->addContent(Message::MESSAGE_TYPE_IMAGE_URL, 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg');
$message->addContent(Message::MESSAGE_TYPE_IMAGE_URL, 'https://www.wolframcloud.com/obj/resourcesystem/images/a0e/a0ee3983-46c6-4c92-b85d-059044639928/6af8cfb971db031b.png');
$message->addContent(Message::MESSAGE_TYPE_BASE64, realpath('./../../medias/pixtral_image_example_charts.jpeg'));

$messages = $client->newMessages();
$messages->addMessage($message);

$result = $client->chat($messages, [
    'model' => 'microsoft/Phi-3.5-vision-instruct',
    'max_tokens' => 1024,
]);

echo $result->getMessage();
```

> [!NOTE]
> Supported **image formats** typically include PNG, JPEG, and WEBP, but model compatibility may vary.

---

## Video Analysis (URL)

This sends a **video URL** for analysis.

```php
$message = $client->newMessage();
$message->setRole('user');
$message->addContent(Message::MESSAGE_TYPE_TEXT, "What's in this video?");
$message->addContent(Message::MESSAGE_TYPE_VIDEO_URL, 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4');

$messages = $client->newMessages();
$messages->addMessage($message);

$result = $client->chat($messages, [
    'model' => 'llava-hf/llava-onevision-qwen2-0.5b-ov-hf',
    'max_tokens' => 1024,
]);

echo $result->getMessage();
```

---

## Video Analysis (Base64)

This downloads the video and sends it as **base64** data.

```php
$filePath = $client->downloadToTmp('http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4');

$message = $client->newMessage();
$message->setRole('user');
$message->addContent(Message::MESSAGE_TYPE_TEXT, "What's in this video?");
$message->addContent(Message::MESSAGE_TYPE_BASE64, realpath($filePath));

$messages = $client->newMessages();
$messages->addMessage($message);

$result = $client->chat($messages, [
    'model' => 'llava-hf/llava-onevision-qwen2-0.5b-ov-hf',
    'max_tokens' => 1024,
]);

echo $result->getMessage();
```

> [!TIP]
> Use the `downloadToTmp()` helper to fetch remote files.

---

## Audio Analysis (URL)

This sends an **audio file** via URL for transcription and summarization.

```php
$message = $client->newMessage();
$message->setRole('user');
$message->addContent(Message::MESSAGE_TYPE_TEXT, "Describe this content?");
$message->addContent(Message::MESSAGE_TYPE_AUDIO_URL, 'https://github.com/partITech/php-mistral/raw/refs/heads/psr18/examples/medias/mit.mp3');

$messages = $client->newMessages();
$messages->addMessage($message);

$result = $client->chat($messages, [
    'model' => 'fixie-ai/ultravox-v0_5-llama-3_2-1b',
    'max_tokens' => 1024,
]);

echo $result->getMessage();
```

---

## Audio Analysis (Base64)

This sends the **audio file as base64**.

```php
$message = $client->newMessage();
$message->setRole('user');
$message->addContent(Message::MESSAGE_TYPE_TEXT, "Describe this content?");
$message->addContent(Message::MESSAGE_TYPE_BASE64, realpath('./../../medias/mit.wav'));

$messages = $client->newMessages();
$messages->addMessage($message);

$result = $client->chat($messages, [
    'model' => 'fixie-ai/ultravox-v0_5-llama-3_2-1b',
    'max_tokens' => 1024,
]);

echo $result->getMessage();
```

---

## Supported Content Types

| Content Type                    | Constant Name                     |
|----------------------------------|-----------------------------------|
| **Text**                         | `Message::MESSAGE_TYPE_TEXT`      |
| **Image (URL)**                  | `Message::MESSAGE_TYPE_IMAGE_URL` |
| **Image (Base64)**               | `Message::MESSAGE_TYPE_BASE64`    |
| **Video (URL)**                  | `Message::MESSAGE_TYPE_VIDEO_URL` |
| **Video (Base64)**               | `Message::MESSAGE_TYPE_BASE64`    |
| **Audio (URL)**                  | `Message::MESSAGE_TYPE_AUDIO_URL` |
| **Audio (Base64)**               | `Message::MESSAGE_TYPE_BASE64`    |

> [!CAUTION]
> Some models may only support specific media formats or types. Refer to the model documentation or experiment accordingly.

> [!TIP]
> Mixing **multiple media types** (text, image, video, audio) in a single message allows rich **contextual interactions**, making the most of multimodal models.
