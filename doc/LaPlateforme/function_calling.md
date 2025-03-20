## Function calling


### Understanding an AI Agent and Its Role

An **AI agent** is a system that can make decisions, retrieve data dynamically, and interact with users in a meaningful way. In the context of Mistral API's **function calling**, an agent acts as a bridge between a language model and external functions, allowing the model to execute actions based on user queries.

The key concepts behind an AI agent are:

1. **Decision Making** – The model chooses which function (tool) to use.
2. **Dynamic Data Retrieval** – The model does not have all the data but can call external sources.
3. **Executing Functions** – Once a function is selected, its output is used in the response.

This approach enables the model to respond with precise, up-to-date, and relevant information rather than relying on static knowledge.

---

### How Does an Agent Work?

An agent's workflow consists of several steps:

1. **Defining Available Tools**
    - These tools are PHP functions (or API calls) the model can use.
    - Each tool has a name, a description, and parameters.

2. **User Interaction**
    - The user asks a question.
    - The model determines if it has enough information to respond or if it needs to call a tool.

3. **Tool Selection and Execution**
    - The model selects the relevant tool and provides input parameters.
    - The tool executes and returns a response.

4. **Final Response Generation**
    - The model integrates the tool's output into a human-like response.
    - The conversation history is updated to ensure coherence.


---

### Example: Payment Status Inquiry

#### Step 1: Define Data and Functions

We have transaction data stored in an array:

```php
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
```
To allow the agent to retrieve payment information, we define callable functions:

#### Example Functions
```php
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
```

Now, we link function names to actual callable functions:

```php
$namesToFunctions = [
    "retrievePaymentStatus" => $retrievePaymentStatus(...),
    "retrievePaymentDate" => $retrievePaymentDate(...)
];
```

#### Step 2: Define the Tools for the Agent

To enable the agent to call these functions, we define them using `FunctionTool` and `Tool` objects.

```php
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
```
This allows the model to "see" which functions it can use.

json output :
```json
[
    {
        "type": "function",
        "function": {
        "name": "retrievePaymentStatus",
            "description": "Get payment status of a transaction id",
            "parameters": {
            "type": "object",
                "required": [
                "transactionId"
            ],
                "properties": {
                "transactionId": {
                    "type": "string",
                        "description": "The transaction id."
                    }
                }
            }
        }
    },
    {
        "type": "function",
        "function": {
        "name": "retrievePaymentDate",
            "description": "Get payment date of a transaction id",
            "parameters": {
            "type": "object",
                "required": [
                "transactionId"
            ],
                "properties": {
                "transactionId": {
                    "type": "string",
                        "description": "The transaction id."
                    }
                }
            }
        }
    }
]
```

#### Step 3: The User Asks a Question

When a user interacts with the chatbot, the conversation starts:

```php
$messages = new Messages();
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
```

Since the model lacks a transaction ID, it will likely ask for one:
```text
 I'd be happy to help you with that!
 However, I'll need a bit more information to provide a useful response.
 Could you please tell me the type of transaction you're referring to? It could be a bank transaction,
 a purchase from an online store, a cryptocurrency transfer, or something else.
 Additionally, if you have any specific details like a transaction ID, that would be very helpful.
 Please note that I can't access personal data or account details, but I can guide you on how to check the status.
```

#### Step 4: User Provides the Transaction ID

Now, the user responds with a transaction ID:
```php
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
```
The agent now has enough information to retrieve the status.

#### Step 5: The Agent Calls the Correct Function

The model selects the appropriate function and passes the transaction ID:
```php
$toolCallResponse = $chatResponse->getToolCalls();
$toolCall = $toolCallResponse[0];
$functionName = $toolCall['function']['name'];
$functionParams = $toolCall['function']['arguments'];

// Call the proper function
$functionResult = $namesToFunctions[$functionName]($functionParams);
```

```php
print_r($toolCall);
Array
(
    [id] => 1b9Ds90lR
    [function] => Array
        (
            [name] => retrievePaymentStatus
            [arguments] => Array
                (
                    [transactionId] => T1001
                )
        )
)

print_r($functionResult);
Array
(
    [status] => Paid
)

print_r($functionParams);
Array
(
    [transactionId] => T1001
)
```

#### Step 6: The Model Forms a Final Response

The result is added to the chat history:

```php
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
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

Now, the final response:

```text
The status of your transaction with ID T1001 is 'Paid'. Is there anything else you need help with?
```
---

## Summary: How an AI Agent Works

An **AI agent** follows a structured process to assist users efficiently:

1. **Receiving User Queries**
    - The agent starts by understanding the user's request.

2. **Identifying Missing Information**
    - If the agent lacks details (e.g., a transaction ID), it asks clarifying questions.

3. **Choosing the Right Function**
    - Based on the request, the agent selects the appropriate tool or function.

4. **Retrieving Real-Time Data**
    - The agent executes the selected function, fetching data from an external source (database, API, etc.).

5. **Generating the Response**
    - The result is incorporated into a natural response for the user.

This **function-calling mechanism** allows the agent to **fetch dynamic data** rather than relying solely on pre-trained knowledge.

---

## Why This Approach Matters

- **Scalability** – Easily extend functionality by adding new tools.
- **Automation** – Reduces manual effort for common queries.
- **Accuracy** – Provides real-time answers based on external data.
- **Flexibility** – Works across different industries, from finance to customer support.

By structuring your AI with function calls, you create a **responsive, intelligent assistant** that adapts to user needs dynamically.