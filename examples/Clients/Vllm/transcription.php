<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');   // "personal_token"
$urlApiTranscription    =  getenv('VLLM_API_TRANSCRIPTION_URL');  // "http://localhost:40003"
$transcriptionModel = getenv('VLLM_API_TRANSCRIPTION_MODEL'); // openai/whisper-small

$client = new VllmClient(apiKey: (string) $apiKey, url:  $urlApiTranscription);

$path = $filePath = realpath("./../../medias/mit.mp3");
try {
    $response = $client->transcription(path: $path, model: $transcriptionModel);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($response);

/*
  Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files.

 */