## Download

#### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $dest = $client->downloadDatasetFiles('google/civil_comments', revision: 'main', destination: '/tmp/downloaded_datasets/civil_comments');
    print_r($dest);
} catch ( \Throwable $e) {
    $e->getMessage();
}
```


#### Result

```text
/tmp/downloaded_datasets/civil_comments
```

```shell 
tree /tmp/downloaded_datasets/civil_comments

/tmp/downloaded_datasets/civil_comments
├── data
│   ├── test-00000-of-00001.parquet
│   ├── train-00000-of-00002.parquet
│   ├── train-00001-of-00002.parquet
│   └── validation-00000-of-00001.parquet
└── README.md
```