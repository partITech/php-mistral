<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$contents = [
    ['type' => 'text', 'text' => 'Describe this image in detail please.'],
    ['type' => 'image_url', 'image_url' => 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg'],
    ['type' => 'text', 'text' => 'and this one as well. Answer in French.'],
    ['type' => 'image_url', 'image_url' => 'https://www.wolframcloud.com/obj/resourcesystem/images/a0e/a0ee3983-46c6-4c92-b85d-059044639928/6af8cfb971db031b.png']
];


$messages = new Messages();
$messages->addMixedContentUserMessage($contents);
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'Pixtral-12B-2409',
            'max_tokens' => 1024,
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());

// Dans cette image, on voit une famille de cinq personnes posant pour une photo. Ils sont tous vêtus de chemises rouges assorties et sont allongés sur le ventre sur une surface blanche devant un fond blanc. Les membres de la famille sourient et semblent être dans une pose détendue et joyeuse, les mains jointes devant eux. La famille semble former un groupe uni et heureux, et l'ambiance générale de la photo est chaleureuse et accueillante.