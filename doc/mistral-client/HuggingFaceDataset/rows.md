## Rows

The **Rows API** retrieves specific **rows** from a Hugging Face dataset repository, allowing you to **paginate through large datasets** without downloading the entire content. This method is ideal for working with **large datasets** in a **memory-efficient** manner.

> [!TIP]
> Use this method to **preview or process dataset rows** in chunks, especially when dealing with millions of samples.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');  // Hugging Face API token

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Retrieve rows 3 and 4 from the 'nvidia/OpenCodeReasoning' dataset, 'split_0' config and split
    $firstRows = $client->rows(
        dataset: 'nvidia/OpenCodeReasoning', 
        split: 'split_0', 
        config: 'split_0',  // For multi-config datasets
        offset: 3,          // Starting from row index 3
        length: 2           // Retrieve 2 rows
    );

    print_r($firstRows);  // Output features and rows

} catch (MistralClientException $e) {
    print_r($e);
}
```

---

### Result

```text
Array
(
    [features] => Array
        (
            [0] => Array ( [feature_idx] => 0 [name] => id [type] => Array ( [dtype] => string [_type] => Value ) )
            [1] => Array ( [feature_idx] => 1 [name] => input [type] => Array ( [dtype] => string [_type] => Value ) )
            [2] => Array ( [feature_idx] => 2 [name] => output [type] => Array ( [dtype] => string [_type] => Value ) )
            ...
        )
    [rows] => Array
        (
            [0] => Array
                (
                    [row_idx] => 3
                    [row] => Array
                        (
                            [id] => e2e75d9d7d47d6f22c7eb408f8911af8
                            [input] => A Little Elephant from the Zoo of Lviv likes lucky strings...
                            [output] => <think> Okay, I need to solve this problem...
                            ...
                        )
                )
        )
    [num_rows_total] => 170361
    [num_rows_per_page] => 100
    [partial] => 1
)
```

---

### Parameters

| Parameter  | Description                                                       |
|------------|-------------------------------------------------------------------|
| `dataset`  | Name of the dataset (e.g., `nvidia/OpenCodeReasoning`).           |
| `split`    | The dataset split (e.g., `train`, `test`, `validation`, or custom).|
| `config`   | Dataset configuration (for multi-config datasets, optional).      |
| `offset`   | Starting row index (0-based).                                     |
| `length`   | Number of rows to retrieve from the offset.                       |

---

### Returned Fields

- **features**: Schema of the dataset (column names and types).
- **rows**: Retrieved rows, including:
    - `row_idx`: Global row index.
    - `row`: Data for each feature (field).
- **num_rows_total**: Total number of rows in the dataset split.
- **num_rows_per_page**: Default rows per page (pagination size).
- **partial**: Indicates if the result is partial (1 = partial, 0 = full).

> [!NOTE]
> The `partial` flag is useful when paginating through large datasets, confirming if more data remains.

---

### Use Cases

- **Pagination**: Retrieve dataset rows in small batches (ideal for large datasets).
- **Custom data exploration**: Load specific dataset segments for preview or processing.
- **Efficient sampling**: Access specific rows without downloading the entire dataset.

---

### Common Pitfalls

> [!WARNING]
> - Ensure the **split** and **config** parameters match the dataset structure. Use the **First Row API** to explore available splits and configurations.
> - **Offset** and **length** should be within dataset bounds (check `num_rows_total`).

> [!TIP]
> Combine **Rows** and **First Row** APIs for **dynamic exploration** and **efficient processing** of large datasets.
