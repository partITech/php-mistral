## Search

The **Search API** enables **full-text search** within a Hugging Face **dataset repository**. This is particularly useful when looking for **specific samples** (e.g., rows containing certain keywords) across large datasets.

> [!TIP]
> Use this method to **query specific terms** (e.g., keywords like "love", "error", "classification") within a dataset split, reducing the need to process the entire dataset manually.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');  // Hugging Face API token

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Perform a search query for the keyword 'love' in the 'cornell-movie-review-data/rotten_tomatoes' dataset
    $searchResult = $client->search(
        dataset: 'cornell-movie-review-data/rotten_tomatoes', // Dataset name
        split: 'train',                                       // Dataset split (e.g., train, test)
        config: 'default',                                    // Dataset config (if multi-config)
        query: 'love'                                         // Search query (keyword)
    );

    print_r($searchResult);  // Output search results

} catch (MistralClientException $e) {
    print_r($e);  // Handle errors (e.g., dataset not searchable)
}
```

---

### Result

```text
Array
(
    [features] => Array
        (
            [0] => Array ( [feature_idx] => 0 [name] => text [type] => Array ( [dtype] => string [_type] => Value ) )
            [1] => Array ( [feature_idx] => 1 [name] => label [type] => Array ( [names] => Array ( [0] => neg [1] => pos ) [_type] => ClassLabel ) )
        )
    [rows] => Array
        (
            [0] => Array ( [row_idx] => 6248 [row] => Array ( [text] => who needs love like this ? [label] => 0 ) )
            [1] => Array ( [row_idx] => 1015 [row] => Array ( [text] => if you love motown music , you'll love this documentary . [label] => 1 ) )
            [2] => Array ( [row_idx] => 1042 [row] => Array ( [text] => it's a lovely film with lovely performances by buy and accorsi . [label] => 1 ) )
        )
    [num_rows_total] => 234
    [num_rows_per_page] => 100
    [partial] => 
)
```

- **features**: The dataset schema (columns and types).
- **rows**: Matching rows with:
    - `row_idx`: Global row index in the dataset.
    - `row`: Data fields (e.g., `text`, `label`).
- **num_rows_total**: Total number of matching rows for the query.
- **num_rows_per_page**: Number of rows returned per page (pagination).
- **partial**: Indicates if the result set is partial (1 = partial, 0 = full).

---

### Parameters

| Parameter  | Description                                                       |
|------------|-------------------------------------------------------------------|
| `dataset`  | The dataset name (e.g., `user/dataset`).                          |
| `split`    | The dataset split (e.g., `train`, `test`, `validation`).          |
| `config`   | Dataset configuration (for multi-config datasets).                |
| `query`    | The **text query** to search for within dataset rows.             |

---

### Use Cases

- **Keyword filtering**: Find rows containing specific words or phrases.
- **Data exploration**: Quickly sample relevant entries in large datasets.
- **Debugging**: Search for specific patterns or errors within datasets.

---

### Common Pitfalls

> [!WARNING]
> - **Search is supported only if the dataset viewer supports search**. Use the **Is Valid API** to check.
> - Ensure the **query** term is correctly formatted (simple keywords work best).

> [!TIP]
> Combine this with **Rows** or **First Row** APIs for dynamic data exploration and efficient dataset handling.
