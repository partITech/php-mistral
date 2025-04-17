<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Message;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addDocumentMessage(type: Message::MESSAGE_TYPE_DOCUMENT_URL,    content: 'https://arxiv.org/pdf/1805.04770');

try {
    $result = $client->ocr(
        $messages,
        [
            'model' => 'mistral-ocr-latest',
            'include_image_base64' => true
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($result->getPages());