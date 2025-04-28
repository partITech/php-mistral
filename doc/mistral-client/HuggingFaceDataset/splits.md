## Splits

The **Splits API** retrieves the list of available **splits** (e.g., `train`, `test`, `validation`) for a given Hugging Face **dataset repository**. This is useful to understand the **dataset partitioning** before processing or analyzing it.

> [!TIP]
> Some datasets contain **multiple configurations** and **splits**. This method helps you discover how the dataset is structured.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');  // Hugging Face API token

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Get the splits for the 'google/civil_comments' dataset
    $splits = $client->splits('google/civil_comments');

    print_r($splits);  // Output dataset splits

} catch (MistralClientException $e) {
    print_r($e);
}
```

---

### Result

```text
Array
(
    [splits] => Array
        (
            [0] => Array ( [dataset] => google/civil_comments [config] => default [split] => train )
            [1] => Array ( [dataset] => google/civil_comments [config] => default [split] => validation )
            [2] => Array ( [dataset] => google/civil_comments [config] => default [split] => test )
        )
    [pending] => Array ( )
    [failed] => Array ( )
)
```

- **splits**: Lists all available splits for each dataset configuration.
- **pending**: Lists splits that are **being processed** or **pending generation**.
- **failed**: Lists splits that **failed** during processing (e.g., incompatible file formats).

---

### Returned Fields

| Field     | Description                                              |
|-----------|----------------------------------------------------------|
| `dataset` | Name of the dataset.                                     |
| `config`  | Configuration name (if the dataset has multiple configs).|
| `split`   | Name of the split (e.g., `train`, `test`, `validation`). |

---

### Use Cases

- **Dataset exploration**: Discover the available **splits** and **configurations** before loading data.
- **Pipeline automation**: Dynamically load or process different splits (e.g., only `train`).
- **Error handling**: Detect **pending** or **failed** splits to avoid processing issues.

---

### Common Pitfalls

> [!WARNING]
> - Some datasets **may not have standard splits** (e.g., only `train` or custom names). Always **check the splits** before assuming their names.
> - **Pending** or **failed** splits indicate that **viewer features** (like search or filtering) may not work properly for those splits.

> [!TIP]
> Use this method before invoking **Rows**, **Search**, or **First Row** APIs to ensure you pass valid split names.
