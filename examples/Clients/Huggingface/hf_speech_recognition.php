<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once './../SimpleListSchema.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HUGGINGFACE_TGI_TOKEN');   // "personal_token"

$client = new HuggingFaceClient(apiKey: (string) $apiKey, provider: 'hf-inference', useCache: true, waitForModel: true);

$path = $filePath = realpath("./../../medias/mit.wav");
try {
    $response = $client->transcription(path: $path, model: 'openai/whisper-large-v3');
    echo $response;
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}


/*
 Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files.

 *
 */