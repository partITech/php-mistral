<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Anthropic\AnthropicClient;
use Partitech\PhpMistral\Clients\Client;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Tools\FunctionTool;
use Partitech\PhpMistral\Tools\Parameter;
use Partitech\PhpMistral\Tools\Tool;

$apiKey = getenv('ANTHROPIC_API_KEY');
$temperature = 0.7;
$model = 'claude-3-5-haiku-20241022';

$client = new AnthropicClient(apiKey: (string)$apiKey);

// Assuming we have the following data
$data = [
    "transactionId" => ['T1001', 'T1002', 'T1003', 'T1004', 'T1005'],
    "customerId" => ['C001', 'C002', 'C003', 'C002', 'C001'],
    "paymentAmount" => [125.50, 89.99, 120.00, 54.30, 210.20],
    "paymentDate" => ['2021-10-05', '2021-10-06', '2021-10-07', '2021-10-05', '2021-10-08'],
    "paymentStatus" => ['Paid', 'Unpaid', 'Paid', 'Paid', 'Pending']
];

/**
 * This function retrieves the payment status of a transaction id.
 */
$retrievePaymentStatus = function ($values) use ($data): array|string {
    $transactionId = $values['transactionId'];

    if (!in_array($transactionId, $data['transactionId'])) {
        return ['error' => 'error - transaction id not found.'];
    }

    $key = array_search($transactionId, $data['transactionId']);
    return ['status' => $data['paymentStatus'][$key]];
};


/**
 * This function retrieves the payment date of a transaction id.
 */
$retrievePaymentDate = function ($values) use ($data): array|string {
    $transactionId = $values['transactionId'];

    if (!in_array($transactionId, $data['transactionId'])) {
        return ['error' => 'error - transaction id not found.'];
    }

    $key = array_search($transactionId, $data['transactionId']);
    return ['status' => $data['paymentDate'][$key]];
};

$namesToFunctions = ["retrievePaymentStatus" => $retrievePaymentStatus(...), "retrievePaymentDate" => $retrievePaymentDate(...)];

// Create the tools definition
$transactionIdParam = new Parameter(type: Parameter::STRING_TYPE, name: 'transactionId', description: 'The transaction id.', required: true);

$retrievePaymentStatusFunction = new FunctionTool(name: 'retrievePaymentStatus', description: 'Get payment status of a transaction id', parameters: [$transactionIdParam]);


$retrievePaymentDateFunction = new FunctionTool(name: 'retrievePaymentDate', description: 'Get payment date of a transaction id', parameters: [$transactionIdParam]);

$tools = [new Tool('function', $retrievePaymentStatusFunction), new Tool('function', $retrievePaymentDateFunction),];

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

$messages = new Messages();
$messages->addUserMessage(content: "What's the status of my transaction?");

try {
    $chatResponse = $client->chat(messages: $messages, params: ['temperature' => $temperature, 'max_tokens' => 512, 'model' => $model, 'tools' => $tools, 'tool_choice' => Client::TOOL_CHOICE_TOOL]);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($chatResponse->getMessage());

// will output :
// I apologize, but I cannot check the status of your transaction without knowing the specific transaction ID. Could you please provide me with the transaction ID for which you want to check the status? Once you share the transaction ID, I'll be happy to help you retrieve its payment status.


// Push response to history
$messages->addAssistantMessage(content: $chatResponse->getMessage());
// Add customer response
$messages->addUserMessage(content: 'My transaction ID is T1001.');

try {
    $chatResponse = $client->chat(messages: $messages, params: ['temperature' => $temperature, 'max_tokens' => 512, 'model' => $model, 'tools' => $tools, 'tool_choice' => Client::TOOL_CHOICE_TOOL]);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
$toolCallResponse = $chatResponse->getToolCalls();


$toolCall = $toolCallResponse[0];
$functionName = $toolCall['function']['name'];
$functionParams = $toolCall['function']['arguments'];

// Call the proper function
$functionResult = $namesToFunctions[$functionName]($functionParams);

print_r($toolCall);
//Array
//(
//    [id] => toolu_01BQhkE69PFqdiZJ7FApiwav
//    [function] => Array
//        (
//            [name] => retrievePaymentStatus
//            [arguments] => Array
//                (
//                    [transactionId] => T1001
//                )
//
//        )
//
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
$messages->addAssistantMessage(content: $chatResponse->getMessage(),
// Do not use toolCalls with anthropic. passed toolcall are defined in the message content section.
// toolCalls: $chatResponse->getToolCalls()
);

// Add the tool message to query anthropic for a message
// For anthropic you will need to add specific clientType as the tools response is not in a mistral nor vllm way
$messages->addToolMessage(name: $toolCall['function']['name'], content: $namesToFunctions[$functionName]($functionParams), toolCallId: $toolCall['id']);

try {
    $chatResponse = $client->chat(messages: $messages, params: ['model' => $model, 'tools' => $tools, 'max_tokens' => 512, 'tool_choice' => Client::TOOL_CHOICE_AUTO]);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($chatResponse->getMessage());
//The status of your transaction T1001 is "Paid".
//
//Would you like to know anything else about this transaction, such as the payment date?