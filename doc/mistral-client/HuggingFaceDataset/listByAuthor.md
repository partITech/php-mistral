## List by author

The **List Datasets API** retrieves the list of **datasets** published by a specific Hugging Face **user** or **organization**. This method supports **pagination**, **sorting**, and can retrieve either **basic metadata** or **full dataset details**.

> [!TIP]
> Use this method to explore datasets for a given author, check recent updates, or build dataset discovery features in your applications.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');       // Hugging Face API token
$datasetUser = getenv('HF_USER');   // Hugging Face username or organization

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // List datasets by author with detailed metadata
    $datasets = $client->listDatasets(
        author: $datasetUser,      // Author username or organization
        limit: 5,                  // Limit results (pagination)
        sort: 'lastModified',      // Sort by last modification date
        direction: -1,             // Direction: -1 (descending), 1 (ascending)
        full: true                 // Retrieve full dataset metadata (set to false for basic info)
    );

    print_r($datasets);  // Output dataset metadata

} catch (MistralClientException $e) {
    print_r($e);
}
```

---

### Result

```text
Array
(
    [0] => Array
        (
            [id] => Bourdin/test3
            [author] => Bourdin
            [cardData] => Array
                (
                    [language] => Array ( [0] => en )
                    [license] => cc0-1.0
                    [task_categories] => Array ( [0] => text-classification )
                    [task_ids] => Array ( [0] => multi-label-classification )
                    [dataset_info] => Array
                        (
                            [features] => Array
                                (
                                    [0] => Array ( [name] => text [dtype] => string )
                                    [1] => Array ( [name] => toxicity [dtype] => float32 )
                                    ...
                                )
                            [splits] => Array
                                (
                                    [0] => Array ( [name] => train [num_examples] => 1804874 )
                                    [1] => Array ( [name] => validation [num_examples] => 97320 )
                                    ...
                                )
                        )
                )
            [lastModified] => 2025-04-24T15:16:05.000Z
            [description] => Dataset Card for "civil_comments" ...
        )
)
```

---

### Parameters

| Parameter  | Description                                                               |
|------------|---------------------------------------------------------------------------|
| `author`   | The username or organization name on Hugging Face.                        |
| `limit`    | Maximum number of datasets to retrieve (pagination).                      |
| `sort`     | Field to sort by (`lastModified`, `createdAt`, `downloads`, etc.).        |
| `direction`| Sorting direction: `-1` (descending) or `1` (ascending).                  |
| `full`     | Whether to retrieve **full dataset metadata** (set to `false` for basic). |

---

### Dataset Metadata (Full Mode)

When `full: true`, each dataset entry includes:

- **id**: Dataset identifier (e.g., `user/dataset`).
- **author**: Dataset author.
- **cardData**: Dataset card metadata (language, license, tags, task categories, etc.).
- **dataset_info**: Features, splits, download size, etc.
- **lastModified**: Last update timestamp.
- **description**: Dataset description (shortened if too long).

> [!NOTE]
> In **basic mode** (`full: false`), only key fields like `id`, `author`, and `lastModified` are returned.

---

### Use Cases

- **Dataset discovery**: List and filter datasets for a specific user or organization.
- **Metadata inspection**: Retrieve detailed information about datasets (features, splits, licenses).
- **Monitoring**: Track dataset updates (using `lastModified`).

---

### Common Pitfalls

> [!WARNING]
> - Make sure the **author name** is correct. Organizations and personal accounts are case-sensitive.
> - When retrieving **full metadata**, performance may vary depending on the number of datasets.

> [!TIP]
> Use **pagination** (via `limit`) for scalable dataset listings, especially for users with many datasets.
