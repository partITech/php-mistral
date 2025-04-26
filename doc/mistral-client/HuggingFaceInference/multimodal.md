## Multimodal

### Code
```php
$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$message = $client->newMessage();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: 'Describe this image in detail please.');
$message->addContent(type: Message::MESSAGE_TYPE_IMAGE_URL,    content: 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg');
$messages = new Messages();
$messages->addMessage($message);

$params = [
    'model' => 'Qwen/Qwen2.5-VL-7B-Instruct',
    'max_tokens' => 15000,
    'max_new_tokens' => 15000,
    'max_length' => 15000
];

try {
    $chatResponse = $client->chat(
        $messages,
        $params
    );
    print_r($chatResponse->getMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

### Result

```text
The image depicts three people running outdoors in a natural setting, surrounded by lush greenery. The background appears to be a serene, green forest or park, indicating a healthy and active environment. The participants are in motion, suggesting they are engaged in a fitness activity.

- The individual on the left is a man wearing a gray, long-sleeved, dotted athletic top and black athletic shorts. He has short hair and is smiling as he runs, showing an active and pleasant demeanor.
- The individual in the middle is a woman wearing a bright lime-green tank top and black athletic shorts. She is running with a cheerful expression and appears to be mid-stride, showing energy and movement.
- The individual on the right is a woman wearing a pink, long-sleeved, ribbed athletic top and black athletic leggings. She has curly hair that flows naturally with her movement and is also smiling, contributing to the overall positive and dynamic scene.

The lighting in the image is bright, suggesting it was taken during the day, possibly in the morning or late afternoon when the sun is softer. The overall atmosphere of the image is one of enthusiasm and camaraderie, emphasizing the joy derived from outdoor physical activities.

```
