<?php

use Partitech\PhpMistral\Clients\Tei\TeiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

require_once __DIR__ . '/../../../../vendor/autoload.php';

$teiUrl = getenv('TEI_RERANK_URI');
$apiKey = getenv('TEI_API_KEY');

$client = new TeiClient(apiKey: (string) $apiKey, url: $teiUrl);

try {
    $tokens = $client->rerank(
        query: 'What is the difference between Deep Learning and Machine Learning?',
        texts: [
            'Deep learning is...',
            'cheese is made of',
            'Deep Learning is not...'
        ]

    );
    var_dump($tokens);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}


/*
array(3) {
  [0]=>
  array(2) {
    ["index"]=>
    int(0)
    ["score"]=>
    float(0.83828294)
  }
  [1]=>
  array(2) {
    ["index"]=>
    int(2)
    ["score"]=>
    float(0.2656899)
  }
  [2]=>
  array(2) {
    ["index"]=>
    int(1)
    ["score"]=>
    float(3.734357E-5)
  }
}
 */


try {
    $tokens = $client->getRerankedContent(
        query: 'What is the difference between Deep Learning and Machine Learning?',
        texts: [
            'Deep learning is...',
            'cheese is made of',
            'Deep Learning is not...'
        ],
        top: 2
    );
    var_dump($tokens);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}

/*
array(2) {
  [0]=>
  array(3) {
    ["index"]=>
    int(0)
    ["score"]=>
    float(0.83828294)
    ["content"]=>
    string(19) "Deep learning is..."
  }
  [1]=>
  array(3) {
    ["index"]=>
    int(2)
    ["score"]=>
    float(0.2656899)
    ["content"]=>
    string(23) "Deep Learning is not..."
  }
}
*/