## Commit

Commit uses Git LFS and the package `czproject/git-php`. Therefore, you will need Git, Git LFS, and this PHP package if you want to push a dataset to a Hugging Face repository.

#### Code

```php
$apiKey = getenv('HF_TOKEN');
$hfUser = getenv('HF_USER');
$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

// Get the files from your local directory
$files = $client->listFiles('./dir');

try {
    $commit = $client->commit(
        repository: $hfUser . '/test2', 
        dir: realpath('mon_dataset'), 
        files: $files, 
        summary: 'commit title', 
        commitMessage: 'commit message',
        branch: 'main'
     );
    print_r($commit);
} catch (\Throwable $e) {
    print_r($e);
}

```


#### Result

```text
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
```