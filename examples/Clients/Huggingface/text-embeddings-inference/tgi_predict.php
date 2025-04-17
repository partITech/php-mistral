<?php

use Partitech\PhpMistral\Clients\Tei\TeiClient;
use Partitech\PhpMistral\MistralClientException;

require_once __DIR__ . '/../../../../vendor/autoload.php';


$teiUrl = getenv('TEI_SENTIMENT_ANALYSIS_URI');
$apiKey = getenv('TEI_API_KEY');

$client = new TeiClient(apiKey: (string) $apiKey, url: $teiUrl);
try {
    $tokens = $client->predict(inputs: 'I love this product!');
    var_dump($tokens);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}


/*
array(28) {
  [0]=>
  array(2) {
    ["score"]=>
    float(0.9895958)
    ["label"]=>
    string(4) "love"
  }
  [1]=>
  array(2) {
    ["score"]=>
    float(0.004673124)
    ["label"]=>
    string(10) "admiration"
  }
  [2]=>
  array(2) {
    ["score"]=>
    float(0.0010800248)
    ["label"]=>
    string(8) "approval"
  }
  [3]=>
  array(2) {
    ["score"]=>
    float(0.00063367496)
    ["label"]=>
    string(3) "joy"
  }
  [4]=>
  array(2) {
    ["score"]=>
    float(0.00046724264)
    ["label"]=>
    string(7) "neutral"
  }
  [5]=>
  array(2) {
    ["score"]=>
    float(0.0003996538)
    ["label"]=>
    string(9) "gratitude"
  }
  [6]=>
  array(2) {
    ["score"]=>
    float(0.00031987886)
    ["label"]=>
    string(8) "optimism"
  }
  [7]=>
  array(2) {
    ["score"]=>
    float(0.0002481507)
    ["label"]=>
    string(11) "realization"
  }
  [8]=>
  array(2) {
    ["score"]=>
    float(0.00024621957)
    ["label"]=>
    string(11) "disapproval"
  }
  [9]=>
  array(2) {
    ["score"]=>
    float(0.00024430346)
    ["label"]=>
    string(9) "annoyance"
  }
  [10]=>
  array(2) {
    ["score"]=>
    float(0.00022950186)
    ["label"]=>
    string(6) "desire"
  }
  [11]=>
  array(2) {
    ["score"]=>
    float(0.0002207098)
    ["label"]=>
    string(10) "excitement"
  }
  [12]=>
  array(2) {
    ["score"]=>
    float(0.00020733767)
    ["label"]=>
    string(14) "disappointment"
  }
  [13]=>
  array(2) {
    ["score"]=>
    float(0.00019707165)
    ["label"]=>
    string(5) "anger"
  }
  [14]=>
  array(2) {
    ["score"]=>
    float(0.00018731396)
    ["label"]=>
    string(7) "sadness"
  }
  [15]=>
  array(2) {
    ["score"]=>
    float(0.00016922406)
    ["label"]=>
    string(6) "caring"
  }
  [16]=>
  array(2) {
    ["score"]=>
    float(0.00016660048)
    ["label"]=>
    string(9) "amusement"
  }
  [17]=>
  array(2) {
    ["score"]=>
    float(0.00015408026)
    ["label"]=>
    string(9) "confusion"
  }
  [18]=>
  array(2) {
    ["score"]=>
    float(0.00011097985)
    ["label"]=>
    string(7) "disgust"
  }
  [19]=>
  array(2) {
    ["score"]=>
    float(0.0001101162)
    ["label"]=>
    string(8) "surprise"
  }
  [20]=>
  array(2) {
    ["score"]=>
    float(0.000103041304)
    ["label"]=>
    string(9) "curiosity"
  }
  [21]=>
  array(2) {
    ["score"]=>
    float(6.601073E-5)
    ["label"]=>
    string(7) "remorse"
  }
  [22]=>
  array(2) {
    ["score"]=>
    float(4.662613E-5)
    ["label"]=>
    string(4) "fear"
  }
  [23]=>
  array(2) {
    ["score"]=>
    float(2.9521827E-5)
    ["label"]=>
    string(13) "embarrassment"
  }
  [24]=>
  array(2) {
    ["score"]=>
    float(2.6775135E-5)
    ["label"]=>
    string(11) "nervousness"
  }
  [25]=>
  array(2) {
    ["score"]=>
    float(2.6463194E-5)
    ["label"]=>
    string(5) "pride"
  }
  [26]=>
  array(2) {
    ["score"]=>
    float(2.069022E-5)
    ["label"]=>
    string(5) "grief"
  }
  [27]=>
  array(2) {
    ["score"]=>
    float(1.9975467E-5)
    ["label"]=>
    string(6) "relief"
  }
}
 */