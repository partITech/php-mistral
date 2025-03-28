<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'ministral-3b-latest',
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 250,
            'safe_prompt' => false,
            'random_seed' => null
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result->getMessage());
