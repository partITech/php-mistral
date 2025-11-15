<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralAgent;
use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;
use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Mcp\McpConfig;


$apiKey = getenv('MISTRAL_API_KEY');
$agentClient = new MistralAgentClient(apiKey: $apiKey);
$convClient = new MistralConversationClient(apiKey: $apiKey);




$conversations = $convClient->listConversations(page: 1, pageSize: 1);

$payload = $convClient->getPayload();
$contents = $convClient->getContents();


foreach ($conversations->getIterator() as $index => $conversation) {

    echo ("<b><u>" . $index . " " . $conversation->getId() . "</u></b><br />\n");

    $messages = $convClient->getConversationHistory($conversation)->getMessages();
    /**
     * @var  $imsg
     * @var  \Partitech\PhpMistral\Message $message
     */
    foreach ($messages->getIterator() as $imsg => $message) {

        echo $message->getRole() . PHP_EOL;
        if( $message->getRole() === \Partitech\PhpMistral\Messages::ROLE_TOOL){
            echo json_encode($message->getToolCalls()) . PHP_EOL;
        }else{
            echo $message->getContent() . PHP_EOL;
        }
    }
}