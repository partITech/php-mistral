<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Clients\XAi\XAiClient;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

$message = $client->newMessage();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: 'What is in this image?');
$message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: realpath('./../../medias/pixtral_image_example_charts.jpeg'), detail: 'high');
$messages = new Messages();
$messages->addMessage($message);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'grok-2-vision-latest',
            'max_tokens' => 1024,
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());

/*
The image is a comparison of socio-economic indicators between disadvantaged areas and France as a whole, presented by Statista. Here are the details:

1. **% who are part of working-class**:
   - Disadvantaged areas: **33.5%**
   - Whole of France: **14.5%**

2. **Unemployment rate**:
   - Disadvantaged areas: **18.1%**
   - Whole of France: **7.3%**

3. **% of 16-25 year-olds not in school & unemployed**:
   - Disadvantaged areas: **25.2%**
   - Whole of France: **12.9%**

4. **Median monthly income**:
   - Disadvantaged areas: **€1,168**
   - Whole of France: **€1,822**

5. **Poverty rate**:
   - Disadvantaged areas: **43.3%**
   - Whole of France: **15.5%**

6. **Households living in overcrowded housing**:
   - Disadvantaged areas: **22.0%**
   - Whole of France: **8.7%**

**Additional Information:**
- Disadvantaged areas are defined as areas with an average per-capita income of less than €11,250 per year.
- In 2022, 5.4 million people (8% of the population) lived in 5,114 such areas across 859 municipalities.
- The data is from the latest available sources: 2019/2020, except for unemployment which is from 2022.
- Sources include Insee, ONPV, DARES, and Observatoire des Inégalités.
 */

$message = $client->newMessage();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: 'What is in this image?');
$message->addContent(type: Message::MESSAGE_TYPE_IMAGE_URL,    content: 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg', detail: 'high');
$messages = new Messages();
$messages->addMessage($message);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'grok-2-vision-latest',
            'max_tokens' => 1024,
        ]
    );
    echo $result->getMessage();
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



/**
 * The image shows three people jogging together along a green, nature-filled path. They appear to be enjoying a workout in a lush outdoor setting with trees and vegetation surrounding the trail. The runners are wearing athletic clothing - one in a gray shirt with black shorts, another in a bright yellow tank top with black shorts, and the third in a pink top with black leggings. They seem to be running at a comfortable pace, and the scene conveys a sense of health, fitness, and outdoor activity. The natural environment looks bright and vibrant, making it an appealing setting for outdoor exercise.
 */