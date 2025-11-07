#!/usr/bin/php
<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey  = getenv('MISTRAL_API_KEY');

$client = new MistralConversationClient(apiKey: getenv('MISTRAL_API_KEY'));
$conversations = $client->listConversations(page: 0, pageSize: 500);
$count = $conversations->count();


$client->delete($conversations->first());

$conversations = $client->listConversations(page: 0, pageSize: 500);
$count = $conversations->count();
print_r($count);
