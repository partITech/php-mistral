<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$url    =  getenv('VLLM_API_URL');  // "http://localhost:40001"
$client = new VllmClient(apiKey: (string) $apiKey, url:  $url);

$message = $client->newMessage();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: 'Proceed step by step. For each media, describe it carefully.');
$message->addContent(type: Message::MESSAGE_TYPE_IMAGE_URL,    content: 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg');
$message->addContent(type: Message::MESSAGE_TYPE_IMAGE_URL,    content: 'https://www.wolframcloud.com/obj/resourcesystem/images/a0e/a0ee3983-46c6-4c92-b85d-059044639928/6af8cfb971db031b.png');
$message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: realpath('./../../medias/pixtral_image_example_charts.jpeg'));
$messages = $client->newMessages();
$messages->addMessage($message);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'microsoft/Phi-3.5-vision-instruct',
            'max_tokens' => 1024,
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());

/*
The first image shows three individuals jogging in a line through a lush green forest.
 * The person in the middle appears to be a woman with her hair tied back, wearing a neon yellow top and black shorts.
 * The two individuals jogging alongside her are a man in a blue polo shirt and a woman in a pink top and black pants.
 * The environment is serene with abundant trees and greenery around them.
 * The second image is a family portrait where the members are wearing matching red outfits, lying down with their heads
 * close to each other, forming a line. The family consists of two adults and three children, with the two adults appearing
 * to be the parents and the three children their children. The background is a plain white, emphasizing the family.
 * The third image is a statistical infographic titled 'France’s Social Divide' with a comparison of socio-economic
 * indicators between disadvantaged areas and France as a whole. The infographic is divided into two sets of colored bars,
 * red for disadvantaged areas and blue for the whole of France. It shows percentages and monetary values representing
 * different socio-economic factors such as part of working-class population, unemployment rate, educational level,
 * median monthly income, poverty rate, and households living in overcrowded housing. The source of the data is listed
 * at the bottom, along with the logos of 'Insee', 'ONPPV', 'DARES', and 'Observatoire des inégalités'.

 */


$message = new Message();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: "What's in this video?");
$message->addContent(type: Message::MESSAGE_TYPE_VIDEO_URL,    content: 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4');
$messages = new Messages();
$messages->addMessage($message);
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'llava-hf/llava-onevision-qwen2-0.5b-ov-hf',
            'max_tokens' => 1024,
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());
/*
 * The video features a sequence of scenes set in a cozy living room and a cozy room with a television and a laptop on a wooden stand using a projector.
 * It also shows a comfortable couch with a patterned throw and books, people cozying up in a living room, two screens displaying a neo-classical scene,
 * various books, a dog tag scene, a video screen with animals and text, a cozy room with framed pictures and a person wearing a hoodie and jeans seated,
 * two people playing a video game using a camera, a cozy bedroom with a window and multiple frames, a person wearing a violet knit hat and blue jeans playing a video game,
 *  and shows a festive scene with live band music on a portable speaker set up in a living room.

 */

$filePath = $client->downloadToTmp('http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4');

$message = new Message();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: "What's in this video?");
$message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: realpath($filePath));

$messages = new Messages();
$messages->addMessage($message);
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'llava-hf/llava-onevision-qwen2-0.5b-ov-hf',
            'max_tokens' => 1024,
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());
/*
 * The video features a sequence of scenes set in a cozy living room and a cozy room with a television and a laptop on a wooden stand using a projector. It also shows a comfortable couch with a patterned throw and books, people cozying up in a living room, two screens displaying a neo-classical scene, various books, a dog tag scene, a video screen with animals and text, a cozy room with framed pictures and a person wearing a hoodie and jeans seated, two people playing a video game using a camera, a cozy bedroom with a window and multiple frames, a person wearing a violet knit hat and blue jeans playing a video game, and shows a festive scene with live band music on a portable speaker set up in a living room.

 */



$message = new Message();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: "Describe this content?");
$message->addContent(type: Message::MESSAGE_TYPE_AUDIO_URL, content: 'https://github.com/partITech/php-mistral/raw/refs/heads/psr18/examples/medias/mit.mp3');
$messages = new Messages();
$messages->addMessage($message);
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'fixie-ai/ultravox-v0_5-llama-3_2-1b',
            'max_tokens' => 1024,
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());
/*
 *
This content appears to be a license agreement, specifically a "Software License" or a "User License Agreement" that grants permission for any individual to distribute, use, and attempt to modify the software, as long as they are not selling or distributing the software for commercial purposes.

Here's a breakdown of the content:

1. "Permission": The license grants permission to the software owner to permit any person (individual or organization) to obtain a copy of the software.
2. "Free of charge": The software is provided "free of charge", which means the owner does not retain ownership or patent rights to the software.
3. "Any person" refers to individuals who want to use the software under the terms of the license.
4. "Obtaining a copy" means downloading or obtaining a copy of the software from the website or source.
5. "Associated documentation files" refers to any related files or materials that come with the software, such as user guides or documentation.

The language suggests that this license is intended for free and open-source software only, where the software is freely available, and the license is designed for non-commercial use.

 */

$message = new Message();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: "Describe this content?");
$message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: realpath('./../../medias/mit.wav'));
$messages = new Messages();
$messages->addMessage($message);
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'fixie-ai/ultravox-v0_5-llama-3_2-1b',
            'max_tokens' => 1024,
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());

/*
 The content appears to be legal and informational in nature, stating that permission is granted to personally use the software and associated documentation for free.

The language used is straightforward and clear:

- "Permission is hereby granted"
- "free of charge"
- "to any person"

This indicates that the software and related materials will be freely available, and that there are no restrictions or costs associated with using them.
 */