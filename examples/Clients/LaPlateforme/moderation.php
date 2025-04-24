<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Messages;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

// Get the full response from la plateforme for your input message for moderation.
// No moderation is needed for this message.
try {
    $result = $client->moderation(model: 'mistral-moderation-latest' , input: 'you are a very nice person', filter:false);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);

/*
 Array
(
    [id] => 869e8cdec2d74e3ba5ecd2b310f75dc5
    [usage] => Array
        (
            [prompt_tokens] => 9
            [total_tokens] => 98
            [completion_tokens] => 0
            [request_count] => 1
        )

    [model] => mistral-moderation-latest
    [results] => Array
        (
            [0] => Array
                (
                    [category_scores] => Array
                        (
                            [sexual] => 1.8925149561255E-5
                            [hate_and_discrimination] => 6.2050494307186E-5
                            [violence_and_threats] => 0.00020342698553577
                            [dangerous_and_criminal_content] => 7.0311849412974E-5
                            [selfharm] => 6.1441742218449E-6
                            [health] => 1.1478768101369E-5
                            [financial] => 4.7850944611127E-6
                            [law] => 5.093705112813E-6
                            [pii] => 0.00010889690747717
                        )

                    [categories] => Array
                        (
                            [sexual] =>
                            [hate_and_discrimination] =>
                            [violence_and_threats] =>
                            [dangerous_and_criminal_content] =>
                            [selfharm] =>
                            [health] =>
                            [financial] =>
                            [law] =>
                            [pii] =>
                        )

                )

        )

)
 */


// Get the full response from la plateforme for your input message for moderation
try {
    $result = $client->moderation(model: 'mistral-moderation-latest' , input: 'you are a disgusting person', filter: false);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);

/*
 Array
(
    [id] => b3143e8647e24debb4877accf2ad72cb
    [usage] => Array
        (
            [prompt_tokens] => 9
            [total_tokens] => 98
            [completion_tokens] => 0
            [request_count] => 1
        )

    [model] => mistral-moderation-latest
    [results] => Array
        (
            [0] => Array
                (
                    [category_scores] => Array
                        (
                            [sexual] => 6.2050494307186E-5
                            [hate_and_discrimination] => 0.96978539228439
                            [violence_and_threats] => 0.0010005044750869
                            [dangerous_and_criminal_content] => 2.1444948288263E-5
                            [selfharm] => 8.4811035776511E-5
                            [health] => 2.0145691451035E-5
                            [financial] => 9.5162513389369E-6
                            [law] => 3.2887492125155E-6
                            [pii] => 0.00010229986219201
                        )

                    [categories] => Array
                        (
                            [sexual] =>
                            [hate_and_discrimination] => 1
                            [violence_and_threats] =>
                            [dangerous_and_criminal_content] =>
                            [selfharm] =>
                            [health] =>
                            [financial] =>
                            [law] =>
                            [pii] =>
                        )

                )

        )

)
 */



try {
    $result = $client->moderation(model: 'mistral-moderation-latest' , input: 'you are a disgusting person', filter: true);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);


try {
    $result = $client->moderation(model: 'mistral-moderation-latest' , input: 'you are a nice person', filter: true);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);



try {
    $result = $client->moderation(model: 'mistral-moderation-latest' , input: ['you are very nice person', 'you are a disgusting person' ], filter:true);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


print_r($result);
/*
 Array
(
    [0] => Array
        (
        )

    [1] => Array
        (
            [0] => hate_and_discrimination
        )

)
 */