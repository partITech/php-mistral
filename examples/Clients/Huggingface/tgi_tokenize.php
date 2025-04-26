<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Tgi\TgiClient;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"
$tgiUrl = getenv('TGI_URL');   // "self hosted tgi"

$client = new TgiClient(apiKey: (string) $apiKey, url: $tgiUrl);
try {
    $tokens = $client->tokenize(inputs: "My name is Olivier and I");
    var_dump($tokens);
} catch (\Partitech\PhpMistral\MistralClientException $e) {
    echo $e->getMessage();
}


/*
object(Partitech\PhpMistral\Tokens)#28 (1) {
  ["tokens":"Partitech\PhpMistral\Tokens":private]=>
  object(ArrayObject)#30 (1) {
    ["storage":"ArrayObject":private]=>
    array(7) {
      [0]=>
      array(4) {
        ["id"]=>
        int(1)
        ["text"]=>
        string(0) ""
        ["start"]=>
        int(0)
        ["stop"]=>
        int(0)
      }
      [1]=>
      array(4) {
        ["id"]=>
        int(6720)
        ["text"]=>
        string(2) "My"
        ["start"]=>
        int(0)
        ["stop"]=>
        int(2)
      }
      [2]=>
      array(4) {
        ["id"]=>
        int(2564)
        ["text"]=>
        string(5) " name"
        ["start"]=>
        int(2)
        ["stop"]=>
        int(7)
      }
      [3]=>
      array(4) {
        ["id"]=>
        int(1395)
        ["text"]=>
        string(3) " is"
        ["start"]=>
        int(7)
        ["stop"]=>
        int(10)
      }
      [4]=>
      array(4) {
        ["id"]=>
        int(46091)
        ["text"]=>
        string(8) " Olivier"
        ["start"]=>
        int(10)
        ["stop"]=>
        int(18)
      }
      [5]=>
      array(4) {
        ["id"]=>
        int(1321)
        ["text"]=>
        string(4) " and"
        ["start"]=>
        int(18)
        ["stop"]=>
        int(22)
      }
      [6]=>
      array(4) {
        ["id"]=>
        int(1362)
        ["text"]=>
        string(2) " I"
        ["start"]=>
        int(22)
        ["stop"]=>
        int(24)
      }
    }
  }
  ["prompt":"Partitech\PhpMistral\Tokens":private]=>
  uninitialized(?string)
  ["model":"Partitech\PhpMistral\Tokens":private]=>
  uninitialized(string)
  ["maxModelLength":"Partitech\PhpMistral\Tokens":private]=>
  uninitialized(int)
}
 */