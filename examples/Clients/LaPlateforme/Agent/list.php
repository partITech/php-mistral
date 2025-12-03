#!/usr/bin/php
<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey  = getenv('MISTRAL_API_KEY');

$client = new MistralAgentClient(apiKey: getenv('MISTRAL_API_KEY'));
$agents = $client->listAgents(page: 0, pageSize: 100);
foreach ($agents as $agent) {
    var_dump($agent);
    echo "#{$agent->getId()} - {$agent->getName()} - {$agent->getVersion()}" . PHP_EOL;
}