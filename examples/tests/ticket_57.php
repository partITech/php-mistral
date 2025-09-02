<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralAgent;
use Partitech\PhpMistral\Clients\Mistral\MistralAgentClient;
use Partitech\PhpMistral\Clients\Mistral\MistralConversation;
use Partitech\PhpMistral\Clients\Mistral\MistralConversationClient;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\Parameter;
use Partitech\PhpMistral\Tools\Tool;

$apiKey = getenv('MISTRAL_API_KEY');
$model = 'mistral-small-latest';
$temperature = 0.3;


// ------------------------
// Paramètres de fonctions
// ------------------------

$ParamInfoType = new Parameter(
    type: Parameter::STRING_TYPE,
    name: 'infotype',
    description: "Type informations de l'utilisateur : repas, glycémie, insuline, poids, Pas/Calories.",
    required: true
);

$ParamDateHeure = new Parameter(
    type: Parameter::STRING_TYPE,
    name: 'dateheure',
    description: "Date heure de l'information.",
    required: true
);

$ParamFaim = new Parameter(
    type: Parameter::STRING_TYPE,
    name: 'faim',
    description: "Est ce que tu as faim ?",
    required: true
);

$ParamDonner = new Parameter(
    type: Parameter::STRING_TYPE,
    name: 'donner',
    description: "On donne quelque chose",
    required: true
);

$ParamAManger = new Parameter(
    type: Parameter::STRING_TYPE,
    name: 'a_manger',
    description: "On donne quelque chose à manger ou non",
    required: false
);

$ParamPoches = new Parameter(
    type: Parameter::STRING_TYPE,
    name: 'poches',
    description: "poches du robot",
    required: false
);

// ------------------------
// Fonctions
// ------------------------

$getInfoTypes = new FunctionTool(
    name: 'get_infotypes',
    description: "Renvoie la valeur des informations de type : repas, glycémie, insuline, poids, Pas/Calories",
    parameters: [
        $ParamInfoType,
        $ParamDateHeure
    ]
);

$getFaim = new FunctionTool(
    name: 'get_faim',
    description: "Interroge le robot pour savoir s'il a faim.",
    parameters: [
        $ParamFaim
    ]
);

$getDonner = new FunctionTool(
    name: 'get_donner',
    description: 'L\'utilisateur donne quelque chose au robot',
    parameters: [
        $ParamDonner,
        $ParamAManger
    ]
);

$getPoches = new FunctionTool(
    name: 'get_poches',
    description: 'L\'utilisateur demande ce qu\'il y a dans les poches du robot et si cela se mange ou pas',
    parameters: [
        $ParamPoches,
        $ParamAManger
    ]
);


$tools = [
    new Tool('function', $getInfoTypes),
    new Tool('function', $getFaim),
    new Tool('function', $getDonner),
    new Tool('function', $getPoches),
];


// Create an agent to store your tools

$agent = (new MistralAgent(name: 'Simple Agent', model: 'mistral-small-latest'))
    ->setDescription('A simple Agent with persistent state.')
    ->setInstructions('You speak in a mix of french and english')
    ->setDescription('Une conversation de test')
    ->setTools($tools)
    ->setCompletionArgs(['temperature' => 0.3]);

$agentClient = new MistralAgentClient(apiKey: $apiKey);
$myPersonalAgent = null;

try {
    $myPersonalAgent = $agentClient->createAgent($agent);
} catch (\Throwable $e) {
    echo $e->getMessage();
}

$conversation = (new MistralConversation())
    ->setAgent($myPersonalAgent)
    ->setName('Conversation')
    ->setDescription('Une conversation');

$conversationClient = new MistralConversationClient($apiKey);

// Start the conversation with the first message :

$msg = 'Bonjour';
$messages= $conversationClient->getMessages()->addUserMessage($msg);
echo PHP_EOL . '_______________'. PHP_EOL . $msg . PHP_EOL . '___________________' . PHP_EOL;

try {
    $response = $conversationClient->startConversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );
    if($response->getToolCalls()){
        $toolCall = $response->getToolCalls()->first();
        echo PHP_EOL . '_______________TOOL__CALL___________________' . PHP_EOL;
    }else{
        echo PHP_EOL . '____________________________________________' . PHP_EOL;
        echo $response->getMessage();
    }
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$msg = 'Peux-tu jouer avec moi ?';
$messages= $conversationClient->newMessages()->addUserMessage($msg);
echo PHP_EOL . '_______________'. PHP_EOL . $msg . PHP_EOL . '___________________' . PHP_EOL;
try {
    $response = $conversationClient->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    echo $response->getMessage();

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$msg = 'Quelle était ma glycémie le 21/05/2024 ?';
$messages= $conversationClient->newMessages()->addUserMessage($msg);
echo PHP_EOL . '_______________'. PHP_EOL . $msg . PHP_EOL . '___________________' . PHP_EOL;

try {
    $response = $conversationClient->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );
    if($response->getToolCalls()){
        $toolCall = $response->getToolCalls()->first();
        echo PHP_EOL . '_______________TOOL__CALL___________________' . PHP_EOL;
    }else{
        echo PHP_EOL . '____________________________________________' . PHP_EOL;
        echo $response->getMessage();
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$messages = $conversationClient->newMessages()->addToolMessage(
    name: $toolCall->getName(),
    content: '112mg/dL',
    toolCallId: $toolCall->getId()
);

try {
    $response = $conversationClient->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    echo PHP_EOL . '____________________________________________' . PHP_EOL;
    echo $response->getMessage();

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$msg = 'Quel est mon poids a cette même date  ?';
$messages= $conversationClient->newMessages()->addUserMessage($msg);
echo PHP_EOL . '_______________'. PHP_EOL . $msg . PHP_EOL . '___________________' . PHP_EOL;

try {
    $response = $conversationClient->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    if($response->getToolCalls()){
        $toolCall = $response->getToolCalls()->first();
        echo PHP_EOL . '_______________TOOL__CALL___________________' . PHP_EOL;
    }else{
        echo PHP_EOL . '____________________________________________' . PHP_EOL;
        echo $response->getMessage();
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



$messages = $conversationClient->newMessages()->addToolMessage(
    name: $toolCall->getName(),
    content: '75kg',
    toolCallId: $toolCall->getId()
);


try {
    $response = $conversationClient->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    echo PHP_EOL . '____________________________________________' . PHP_EOL;
    echo $response->getMessage();

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}