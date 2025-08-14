#!/usr/bin/php
<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralAgent;
use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey  = getenv('MISTRAL_API_KEY');
$agentId = getenv('MISTRAL_AGENT_ID');

$agent = new MistralAgent(name: 'Simple Agent', model: 'mistral-medium-latest');
$agent->setDescription('A simple Agent with persistent state.');

$client = new MistralAgentClient(apiKey: getenv('MISTRAL_API_KEY'));
$newAgent = null;
try {
    $newAgent = $client->createAgent($agent);
} catch (\Throwable $e) {
    echo $e->getMessage();
}

print_r($newAgent);


$agent = $client->getAgent($newAgent);
print_r($agent);
$agent = $client->getAgent($newAgent->getId());
print_r($agent);


$agent->setDescription('Updated desc')
      ->setInstructions('New instructions')
      ->setCompletionArgs(['temperature' => 0.1]);

$updated = $client->updateAgent($agent);
print_r($updated);


$updated = $client->updateAgentVersion($agent, 1);
print_r($updated);

//Partitech\PhpMistral\Clients\Mistral\MistralAgent Object
//(
//    [id:protected] => ag_01982d85718d7607928e2b21e1ddd4b8
//    [name:protected] => Simple Agent
//    [model:protected] => mistral-medium-latest
//    [description:protected] => Updated desc
//    [instructions:protected] => New instructions
//    [tools:protected] => Array
//        (
//        )
//
//    [handoffs:protected] =>
//    [completionArgs:protected] => Array
//        (
//            [stop] =>
//            [presence_penalty] =>
//            [frequency_penalty] =>
//            [temperature] => 0.1
//            [top_p] =>
//            [max_tokens] =>
//            [random_seed] =>
//            [prediction] =>
//            [response_format] =>
//            [tool_choice] => auto
//        )
//
//    [createdAt:protected] => 2025-07-21T15:06:16.850961Z
//    [updatedAt:protected] => 2025-07-21T15:06:17.106661Z
//    [version:protected] => 1
//)