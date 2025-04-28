## Download

The **Download API** allows you to **retrieve dataset files** from a Hugging Face repository directly into your local filesystem. This simplifies accessing datasets programmatically without manual downloads.

> [!TIP]
> This method downloads **all files** from a specified dataset repository (e.g., `.parquet`, `.csv`, `README.md`, etc.) and saves them in a local directory.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;

$apiKey = getenv('HF_TOKEN');  // Hugging Face API token

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Download dataset files from the 'google/civil_comments' repository
    $dest = $client->downloadDatasetFiles(
        'google/civil_comments',              // Repository name (user/repo format)
        revision: 'main',                      // (Optional) Branch or tag (default: main)
        destination: '/tmp/downloaded_datasets/civil_comments'  // Local target directory
    );

    print_r($dest);  // Output destination path

} catch (\Throwable $e) {
    echo $e->getMessage();  // Handle errors (e.g., invalid repo, network issues)
}
```

---

### Result

```text
/tmp/downloaded_datasets/civil_comments
```

The downloaded dataset files will be structured as follows:

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

---

### Use Cases

- **Local dataset processing**: Download datasets for offline analysis or model training.
- **Pipeline integration**: Automatically retrieve datasets as part of a data processing pipeline.
- **Dataset backups**: Keep local copies of specific dataset versions (branches or tags).

---

### Common Pitfalls

> [!WARNING]
> - Ensure the **destination directory** is writable. The method will create the folder if it does not exist.
> - The **Hugging Face API token** is required for **private datasets**. For **public datasets**, authentication is optional but recommended to avoid rate limits.

> [!NOTE]
> The **revision** parameter allows you to specify a particular **branch** or **tag** of the dataset (e.g., `main`, `v1.0`). If omitted, it defaults to `main`.

```