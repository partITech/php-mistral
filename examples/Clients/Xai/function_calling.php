<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Clients\XAi\XAiClient;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\Parameter;
use Partitech\PhpMistral\Tools\Tool;

$temperature = 0.3;
$model='grok-3-latest';
$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

// Assuming we have the following data
$data = [
    "transactionId" => [
        'T1001',
        'T1002',
        'T1003',
        'T1004',
        'T1005'
    ],
    "customerId" => [
        'C001',
        'C002',
        'C003',
        'C002',
        'C001'
    ],
    "paymentAmount" => [
        125.50,
        89.99,
        120.00,
        54.30,
        210.20
    ],
    "paymentDate" => [
        '2021-10-05',
        '2021-10-06',
        '2021-10-07',
        '2021-10-05',
        '2021-10-08'
    ],
    "paymentStatus" => [
        'Paid',
        'Unpaid',
        'Paid',
        'Paid',
        'Pending'
    ]
];

/**
 * This function retrieves the payment status of a transaction id.
 */
$retrievePaymentStatus = function ($values) use ($data): array|string {
    $transactionId = $values['transactionId'];

    if(!in_array($transactionId, $data['transactionId'])) {
        return ['error' => 'error - transaction id not found.'];
    }

    $key = array_search($transactionId, $data['transactionId']);
    return ['status' => $data['paymentStatus'][$key]];
};


/**
 * This function retrieves the payment date of a transaction id.
 */
$retrievePaymentDate = function ($values) use ($data) : array|string {
    $transactionId = $values['transactionId'];

    if(!in_array($transactionId, $data['transactionId'])) {
        return ['error' => 'error - transaction id not found.'];
    }

    $key = array_search($transactionId, $data['transactionId']);
    return ['status' => $data['paymentDate'][$key]];
};

$namesToFunctions = [
    "retrievePaymentStatus" => $retrievePaymentStatus(...),
    "retrievePaymentDate" => $retrievePaymentDate(...)
];

// Create the tools definition
$transactionIdParam = new Parameter(
    type: Parameter::STRING_TYPE,
    name: 'transactionId',
    description: 'The transaction id.',
    required: true
);

$retrievePaymentStatusFunction = new FunctionTool(
    name: 'retrievePaymentStatus',
    description: 'Get payment status of a transaction id',
    parameters: [
        $transactionIdParam
    ]
);


$retrievePaymentDateFunction = new FunctionTool(
    name: 'retrievePaymentDate',
    description: 'Get payment date of a transaction id',
    parameters: [
        $transactionIdParam
    ]
);

$tools = [
    new Tool('function', $retrievePaymentStatusFunction),
    new Tool('function', $retrievePaymentDateFunction),
];

// $tools should be encoded as json by HttpClient.
// $jsonTools = json_encode($tools, JSON_PRETTY_PRINT);
//[
//    {
//        "type": "function",
//        "function": {
//        "name": "retrievePaymentStatus",
//            "description": "Get payment status of a transaction id",
//            "parameters": {
//            "type": "object",
//                "required": [
//                "transactionId"
//            ],
//                "properties": {
//                "transactionId": {
//                    "type": "string",
//                        "description": "The transaction id."
//                    }
//                }
//            }
//        }
//    },
//    {
//        "type": "function",
//        "function": {
//        "name": "retrievePaymentDate",
//            "description": "Get payment date of a transaction id",
//            "parameters": {
//            "type": "object",
//                "required": [
//                "transactionId"
//            ],
//                "properties": {
//                "transactionId": {
//                    "type": "string",
//                        "description": "The transaction id."
//                    }
//                }
//            }
//        }
//    }
//]

$messages = new Messages(Client::TYPE_XAI);
$messages->addUserMessage(content: "What's the status of my transaction?");

try {
    $chatResponse = $client->chat(
        messages: $messages,
        params: [
            'temperature' => $temperature,
            'model' => $model,
            'tools' => $tools,
            'tool_choice' => Client::TOOL_CHOICE_AUTO
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

// print_r($chatResponse->getMessage());
// will output :
// I'd be happy to help you with that!
// However, I'll need a bit more information to provide a useful response.
// Could you please tell me the type of transaction you're referring to? It could be a bank transaction,
// a purchase from an online store, a cryptocurrency transfer, or something else.
// Additionally, if you have any specific details like a transaction ID, that would be very helpful.
// Please note that I can't access personal data or account details, but I can guide you on how to check the status.



// Push response to history
$messages->addAssistantMessage(content: $chatResponse->getMessage());
// Add customer response
$messages->addUserMessage(content: 'My transaction ID is T1001.');

try {
    $chatResponse = $client->chat(
        messages: $messages,
        params: [
            'temperature' => $temperature,
            'model' => $model,
            'tools' => $tools,
            'tool_choice' => Client::TOOL_CHOICE_AUTO
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

$toolCallResponse = $chatResponse->getToolCalls();
$toolCall = $toolCallResponse[0];
$functionName = $toolCall['function']['name'];
$functionParams = $toolCall['function']['arguments'];

// Call the proper function
$functionResult = $namesToFunctions[$functionName]($functionParams);

//print_r($toolCall);
//Array
//(
//    [id] => 1b9Ds90lR
//    [function] => Array
//        (
//            [name] => retrievePaymentStatus
//            [arguments] => Array
//                (
//                    [transactionId] => T1001
//                )
//        )
//)

print_r($functionResult);
//Array
//(
//    [status] => Paid
//)

print_r($functionParams);
//Array
//(
//    [transactionId] => T1001
//)

// Add the last assistant message to messages history
$messages->addAssistantMessage(
    content: $chatResponse->getMessage(),
    toolCalls: $chatResponse->getToolCalls()
);

// Add the tool message to query mistral for a message
$messages->addToolMessage(
    name: $toolCall['function']['name'],
    content: $namesToFunctions[$functionName]($functionParams),
    toolCallId: $toolCall['id']
);

try {
    $chatResponse = $client->chat(
        messages: $messages,
        params: [
            'model' => $model,
            'tools' => $tools,
            'tool_choice' => Client::TOOL_CHOICE_AUTO
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($chatResponse->getMessage());
// The status of your transaction with ID T1001 is "Paid."