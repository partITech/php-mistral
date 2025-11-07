## Conversations

Create a new conversation, using a base model or an agent and append entries. Completion and tool executions are run and the response is appended to the conversation.Use the returned conversation_id to continue the conversation.

### Get a specific conversation
Retrieve a stored conversation.
Return a MistralConversation object.
```php
$client = new MistralConversationClient(apiKey: getenv('MISTRAL_API_KEY'));
$conversation = $client->getConversation('conv_id');
```

### List all conversations 
Return an `MistralConversations` object wich is an iterable list of `MistralConversation`
```php
$client = new MistralConversationClient(apiKey: getenv('MISTRAL_API_KEY'));
$conversations = $client->listConversations(page: 0, pageSize: 100);

print_r($conversations);
```


### Conversation information
Returns the metadata of a conversation: agent used, model, creation date, duration, etc.

```php
$client = new MistralConversationClient(apiKey: getenv('MISTRAL_API_KEY'));
$conversations = $client->listConversations(page: 0, pageSize: 100);

print_r($conversations[count($conversations)-1]['id']);

$conversation = $client->getConversation($conversations[0]['id']);

print_r($conversation);
```
### Using mistral connectors
In order to use connectors, simply add the tool you need. You can add multiple tools.

```php
$agent = new MistralAgent(name: 'Websearch Agent', model: 'mistral-medium-latest');
$agent->setDescription('Agent able to search information over the web, such as news, weather, sport results...');
$agent->setInstructions('You have the ability to perform web searches with `web_search` to find up-to-date information.');
$agent->addTool('web_search');
$agentClient = new MistralAgentClient(apiKey: $apiKey);
$newAgent = null;
try {
    $newAgent = $agentClient->createAgent($agent);
} catch (\Throwable $e) {
    echo $e->getMessage();
}


$conversation = (new MistralConversation())
    ->setAgent($newAgent)
    ->setName('Demo Conversation')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    ->setTools([])
    ->setCompletionArgs(['temperature' => 0.3]);


$client   = new MistralConversationClient($apiKey);
$messages = $client->getMessages()->addUserMessage('Who won the last European Football cup?');


try {
    $response = $client->conversation(
        conversation: $conversation,
        messages    : $messages,
        store       : true
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
    print_r($response->getReferences());
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   store       : true,
                                   stream      : true
    ) as $chunk) {

        echo PHP_EOL . $chunk->getType() . PHP_EOL;
        if($chunk->getType() === 'message.output.delta'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
            print_r($chunk->getReferences());
        }
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```


### Restart a conversation starting from a given entry.

Simply add the last message entry you want to restart from 

```php
$conversation = (new MistralConversation())
    ->setModel('mistral-medium-latest')
    ->setName('Demo Conversation')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    ->setTools([])
    ->setCompletionArgs(['temperature' => 0.3]);


$client = new MistralConversationClient($apiKey);
$messages= $client->getMessages()->addUserMessage('Write a poem about Paris');
try {
    $response = $client->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$messages= $client->newMessages()->addUserMessage('Now translate it to French');
try {
    $response = $client->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


$conversation = (new MistralConversation())
    ->setModel('mistral-medium-latest')
    ->setName('Demo Conversation')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    ->setTools([])
    ->setCompletionArgs(['temperature' => 0.3]);


$client = new MistralConversationClient($apiKey);
$messages= $client->getMessages()->addUserMessage('Write a poem about Paris');

try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   store       : true,
                                   stream      : true
    ) as $chunk) {

        if($chunk->getType() !== 'conversation.response.done'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
            $conversation->setId($chunk->getId());
        }
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$lasMessageId = $chunk->getLastMessage()->getId();
$messages = $client->newMessages()->addUserMessage('Now translate it to French');


try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   store       : true,
                                   stream      : true
    ) as $chunk) {

        if($chunk->getType() !== 'conversation.response.done'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
            $conversation->setId($chunk->getId());
        }
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



$messages = $client->newMessages()->addUserMessage('give me the first sentence of the poem ? do not translate it.');


try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   store       : true,
                                   stream      : true,
                                   fromEntry   : $lasMessageId
    ) as $chunk) {

        if($chunk->getType() !== 'conversation.response.done'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
            $conversation->setId($chunk->getId());
        }
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```


### Start a conversation

```php
$conversation = (new MistralConversation())
    ->setModel('mistral-medium-latest')
    ->setName('Demo Conversation')
    ->setDescription('Une conversation de test')
    ->setInstructions(null)
    ->setTools([])
    ->setCompletionArgs(['temperature' => 0.3]);


$client = new MistralConversationClient($apiKey);
$messages= $client->getMessages()->addUserMessage('Write a poem about Paris');
try {
    $response = $client->startConversation(
        conversation: $conversation,
        messages: $messages
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}



try {
    /** @var Response $chunk */
    foreach ($client->conversation(conversation: $conversation,
                                   messages    : $messages,
                                   stream      : true,
    ) as $chunk) {

        if($chunk->getType() !== 'conversation.response.done'){
            echo $chunk->getChunk();
        }

        if($chunk->getType() === 'conversation.response.done'){
            print_r($chunk->getUsage());
            print_r($chunk->getId());
        }
        echo PHP_EOL;
        echo $chunk->getType();
        echo PHP_EOL;
        echo $chunk->getChunk();
        echo PHP_EOL;
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

### Append new entries to an existing conversation.

Run completion on the history of the conversation and the user entries. Return the new created entries.
You can use the `appendConversation()` method or simply pass a conversation object to continue your multiturn messages.

```php
$client = new MistralConversationClient($apiKey);
$messages= $client->getMessages()->addUserMessage('Write a poem about Paris');
try {
    $response = $client->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

$messages= $client->newMessages()->addUserMessage('Now translate it to French');
try {
    $response = $client->conversation(
        conversation: $conversation,
        messages: $messages,
        store: true
    );

    print_r($response->getMessage());
    echo PHP_EOL;
    print_r($response->getId());
    $conversation->setId($response->getId());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```
### Delete a conversation

Permanently delete a conversation by its ID. Returns `true` if the deletion was successful, `false` otherwise.

The `delete()` method accepts either a conversation ID (string) or a `MistralConversation` object.

**Parameters:**
- `$conversation` (string|MistralConversation): The conversation ID or conversation object to delete

**Returns:**
- `bool`: `true` if successfully deleted, `false` if an error occurred

**Example:**
```php
$client = new MistralConversationClient(apiKey: getenv('MISTRAL_API_KEY'));
$conversations = $client->listConversations(page: 0, pageSize: 500);
$client->delete($conversations->first());
```
