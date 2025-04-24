<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

/*
commit uses git lfs
sudo apt-get install git-lfs
brew install git-lfs
https://git-lfs.com/
 */
$apiKey = getenv('HF_TOKEN');
$hfUser = getenv('HF_USER');
$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);


$files = $client->listFiles('mon_dataset');

try {
    $commit = $client->commit(repository: $hfUser . '/test2', dir: realpath('mon_dataset'), files: $files, summary: 'commit title', commitMessage: 'commit message', branch: 'main');
    print_r($commit);
} catch (\Throwable $e) {
    print_r($e);
}

/*
Array
(
    [repository] => USER/test2
    [branch] => main
    [commit_message] => commit message
    [files] => Array
        (
            [0] => .gitattributes
            [1] => data/validation-00000-of-00001.parquet
            [2] => data/test-00000-of-00001.parquet
            [3] => data/train-00001-of-00002.parquet
            [4] => data/train-00000-of-00002.parquet
            [5] => README.md
        )

)
*/