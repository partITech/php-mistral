## First Row

The **First Row API** retrieves the **schema (features)** and the **first rows** of a dataset hosted on Hugging Face. This is useful for **previewing dataset structures**, including field names, types, and sample data.

> [!TIP]
> This method is ideal for exploring datasets **without downloading the full dataset**, which is helpful for large datasets.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');  // Hugging Face API token

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Retrieve the first rows of the 'ibm-research/duorc' dataset, 'SelfRC' config, 'train' split
    $firstRows = $client->firstRows(
        dataset: 'ibm-research/duorc', 
        split: 'train', 
        config: 'SelfRC'  // Optional configuration for multi-config datasets
    );

    print_r($firstRows);  // Display the dataset schema and sample rows

} catch (MistralClientException $e) {
    print_r($e->getMessage());
}
```

---

### Result

```text
Array
(
    [dataset] => ibm-research/duorc
    [config] => SelfRC
    [split] => train
    [features] => Array
        (
            [0] => Array
                (
                    [feature_idx] => 0
                    [name] => plot_id
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )
                )
            ...
        )
    [rows] => Array
        (
            [0] => Array
                (
                    [row_idx] => 0
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized...
                            [title] => Ghosts of Mars
                            [question_id] => b440de7d...
                            [question] => How did the police arrive at the Mars mining camp?
                            [answers] => Array
                                (
                                    [0] => They arrived by train.
                                )
                            [no_answer] => 
                        )
                )
            ...
        )
    [truncated] => 1
)
```

- **dataset**: The dataset name.
- **config**: Dataset configuration (for multi-config datasets).
- **split**: Dataset split (e.g., train, test, validation).
- **features**: Schema of the dataset (field names and types).
- **rows**: Sample rows with actual data.
- **truncated**: Indicates whether the row output was truncated (common for large datasets).

---

### Features Format

Each feature (column) includes:

| Field        | Description                                |
|--------------|--------------------------------------------|
| `feature_idx`| Index of the feature (column position).    |
| `name`       | Feature (column) name.                     |
| `type`       | Data type (e.g., string, bool, sequence).  |

Example of a **feature definition**:

```text
Array
(
    [feature_idx] => 5
    [name] => answers
    [type] => Array
        (
            [feature] => Array
                (
                    [dtype] => string
                    [_type] => Value
                )
            [_type] => Sequence
        )
)
```

- **_type**: Describes the type (`Value`, `Sequence`, etc.).
- **dtype**: The data type (e.g., `string`, `bool`, `int`).

---

### Use Cases

- **Schema exploration**: Inspect the dataset's structure before processing or training.
- **Sample data review**: View example rows to understand dataset content.
- **Multi-config datasets**: Select specific configurations or splits (e.g., `SelfRC`, `ParaphraseRC`).

---

### Common Pitfalls

> [!WARNING]
> - Ensure the **split** and **config** names are correct. Use the Hugging Face dataset page to verify available configurations and splits.
> - Some datasets might **truncate long fields** (e.g., text) in the preview for performance reasons. The `truncated` flag indicates if this occurred.

> [!NOTE]
> This API does **not download full datasets**, making it a lightweight option for schema inspection and sample previews.
