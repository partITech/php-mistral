<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\VllmClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$url    =  getenv('VLLM_API_URL');  // "http://localhost:40001"
$client = new VllmClient(apiKey: (string) $apiKey, url:  $url);

//$message = new Message();
//$message->setRole('user');
//$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: 'Describe this image in detail please.');
//$message->addContent(type: Message::MESSAGE_TYPE_IMAGE_URL,    content: 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg');
//$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: 'and theses two images as well. Answer in French.');
//$message->addContent(type: Message::MESSAGE_TYPE_IMAGE_URL,    content: 'https://www.wolframcloud.com/obj/resourcesystem/images/a0e/a0ee3983-46c6-4c92-b85d-059044639928/6af8cfb971db031b.png');
////$message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: realpath('./../../medias/pixtral_image_example_charts.jpeg'));
//$messages = new Messages();
//$messages->addMessage($message);
//
//try {
//    $result = $client->chat(
//        $messages,
//        [
//            'model' => 'microsoft/Phi-3.5-vision-instruct',
//            'max_tokens' => 1024,
//        ]
//    );
//} catch (MistralClientException $e) {
//    echo $e->getMessage();
//    exit(1);
//}
//
//print($result->getMessage());



//$message = new Message();
//$message->setRole('user');
//$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: "What's in this video?");
//$message->addContent(type: Message::MESSAGE_TYPE_VIDEO_URL,    content: 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4');
//$messages = new Messages();
//$messages->addMessage($message);
//try {
//    $result = $client->chat(
//        $messages,
//        [
//            'model' => 'llava-hf/llava-onevision-qwen2-0.5b-ov-hf',
//            'max_tokens' => 1024,
//        ]
//    );
//} catch (MistralClientException $e) {
//    echo $e->getMessage();
//    exit(1);
//}
//
//print($result->getMessage());
/*
 * The video features a sequence of scenes set in a cozy living room and a cozy room with a television and a laptop on a wooden stand using a projector.
 * It also shows a comfortable couch with a patterned throw and books, people cozying up in a living room, two screens displaying a neo-classical scene,
 * various books, a dog tag scene, a video screen with animals and text, a cozy room with framed pictures and a person wearing a hoodie and jeans seated,
 * two people playing a video game using a camera, a cozy bedroom with a window and multiple frames, a person wearing a violet knit hat and blue jeans playing a video game,
 *  and shows a festive scene with live band music on a portable speaker set up in a living room.

 */


$message = new Message();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: "Describe this content?");
$message->addContent(type: Message::MESSAGE_TYPE_AUDIO_URL, content: 'https://file-examples.com/storage/fe11f9541a67d9f2f9b2038/2017/11/file_example_WAV_1MG.wav');
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