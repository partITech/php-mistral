<?php
require __DIR__ . '/../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\Messages;
use \Partitech\PhpMistral\MistralClientException;

// export MISTRAL_API_KEY=
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$messages = new Messages();
$messages->addUserMessage('What is the best French cheese?');
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'mistral-large-latest',
            'temperature' => 0.7,
            'top_p' => 1,
            'max_tokens' => 250,
            'safe_prompt' => false,
            'random_seed' => null
        ]
    );
    echo PHP_EOL.'##################### $result->getMessage()";'.PHP_EOL;
    /*
     * Get the last message response from the server. In fact, it gets the last message from the Messages
     * class, which is a list of messages.
     */
    print_r($result->getMessage());

    echo PHP_EOL.'##################### $result->getChunk()";'.PHP_EOL;
    /*
     * When using streamed response, it get the last chunk of the message yelded by the server.
     */
    print_r($result->getChunk());
    echo PHP_EOL.'##################### $result->getId()";'.PHP_EOL;
    /*
     * Get the id's response from the serer
     */
    print_r($result->getId());
    echo PHP_EOL.'##################### $result->getChoices()";'.PHP_EOL;
    /*
     * Get array object with choices responses from the server
     */
    print_r($result->getChoices());
    echo PHP_EOL.'##################### $result->getCreated()";'.PHP_EOL;
    /*
     * Get created the created response (integer timestamp)
     */
    print_r($result->getCreated());
    // 171714217
    echo PHP_EOL.'##################### $result->getGuidedMessage()";'.PHP_EOL;
    /*
     * Get the guided message object. basically the same that tthe client provided to vllm.
     * Only use with vllm server
     */
    print_r($result->getGuidedMessage());
    echo PHP_EOL.'##################### $result->getModel()";'.PHP_EOL;
    /*
     * Get the model used.
     */
    print_r($result->getModel());
    // mistral-large-latest
    echo PHP_EOL.'##################### $result->getObject()";'.PHP_EOL;
    /*
     * get the object index from the response
     */
    print_r($result->getObject());
    // chat.completion

    echo PHP_EOL.'##################### $result->getToolCalls()";'.PHP_EOL;
    /*
     * Get function response message from the server
     */
    print_r($result->getToolCalls());


    echo PHP_EOL.'##################### $result->getUsage()";'.PHP_EOL;
    /*
     * Get the usage response from the server.
     */


    print_r($result->getUsage());
    //(
    //    [prompt_tokens] => 10
    //    [total_tokens] => 260
    //    [completion_tokens] => 250
    //)


} catch (MistralClientException $e) {
    echo $e->getMessage();

    exit(1);
}



