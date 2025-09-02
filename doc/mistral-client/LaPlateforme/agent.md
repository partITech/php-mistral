## Agents

AI agents are autonomous systems powered by large language models (LLMs) that, given high-level instructions, can plan, use tools, carry out steps of processing, and take actions to achieve specific goals. These agents leverage advanced natural language processing capabilities to understand and execute complex tasks efficiently and can even collaborate with each other to achieve more sophisticated outcomes.

Set up an agent through the **La platform interface**.  
Here is an example:
![](vids/agent_interface.png)

```text
  - Instructions: You are a French-speaking virtual agent, designed to answer your questions in French only, no matter the language of the question
  - few shot prompt :
         -  question : What's the capital of France ?
         -  answer   : La capitale de la France est Paris.
```

Once you have created your agent, you can use the **agent ID** directly within the chat() method of the MistralClient.

### Without streaming
```php
$apiKey  = getenv('MISTRAL_API_KEY');
$agentId = getenv('MISTRAL_AGENT_ID');

$client = new MistralClient($apiKey);
$messages= $client->getMessages()->addUserMessage('Write a poem about Paris');
try {
    $result = $client->agent(
        messages: $messages,
        agent: $agentId,
        params: [],
        stream: false
    );
    print_r($result->getMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

Example output:
```text
Paris, ville de lumière,
De l'amour et de l'art,
Ses rues étroites et ses larges boulevards,
Sont un enchantement pour le cœur.

La Tour Eiffel, la Seine qui coule,
Le Louvre, le Musée d'Orsay,
Les cafés, les jardins, les ponts,
Paris, tu es magique !

De Montmartre à Montparnasse,
De Saint-Germain à Pigalle,
Chaque quartier a son charme,
Paris, tu es unique !

Ville de la mode et de la gastronomie,
De la liberté et de l'égalité,
Paris, tu es notre capitale,
Notre ville lumière, pour l'éternité.
```


### With streaming

```php
$client = new MistralClient($apiKey);
$messages= $client->getMessages()->addUserMessage('Write a poem about Paris');

try {
    foreach ($client->agent(messages: $messages, agent: $agentId, params: [], stream: true) as $chunk) {
        echo $chunk->getChunk();
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```


Example output:
```text
Paris, ville de lumière,
De l'amour et de l'art,
Ses rues étroites et ses larges boulevards,
Sont un enchantement pour le cœur.

La Tour Eiffel, la Seine qui coule,
Le Louvre, le Musée d'Orsay,
Les cafés, les jardins, les ponts,
Paris, tu es magique !

De Montmartre à Montparnasse,
De Saint-Germain à Pigalle,z
Chaque quartier a son charme,
Paris, tu es unique !

Ville de la mode et de la gastronomie,
De la liberté et de l'égalité,
Paris, tu es notre capitale,
Notre ville lumière, pour l'éternité.
```

**Create an agent**

The Mistral API also allows you to create an agent. The `createAgent` method will return a `MistralAgent` object that you can use in `MistralClient::agent()` or `MistralConversation::setAgent()`.

```php
$agent = (new MistralAgent(name: 'Simple Agent', model: 'mistral-medium-latest'))
->setDescription('A simple Agent with persistent state.')
->setInstructions('You speak in a mix of french and english')
->setDescription('Une conversation de test')
->setTools([])
->setCompletionArgs(['temperature' => 0.3]);

$agentClient = new MistralAgentClient(apiKey: $apiKey);
$newAgent = null;
try {
    $newAgent = $agentClient->createAgent($agent);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
```

**List agents**

Return a list of `MistralAgent`
```php
$client = new MistralAgentClient(apiKey: getenv('MISTRAL_API_KEY'));
$agents = $client->listAgents(page: 0, pageSize: 100);
foreach ($agents as $agent) {
    echo "#{$agent->getId()} - {$agent->getName()} - {$agent->getVersion()}" . PHP_EOL;
}
```


