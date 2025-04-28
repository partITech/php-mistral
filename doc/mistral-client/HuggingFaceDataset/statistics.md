## Statistics

The **Statistics API** provides **descriptive statistics** for each **column** of a dataset split on Hugging Face. It helps you **understand data distributions**, **detect missing values**, and **explore class balance**.

> [!TIP]
> Use this method for **data profiling** and **exploratory data analysis (EDA)** before training models.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');  // Hugging Face API token

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Get statistics for the 'train' split of 'cornell-movie-review-data/rotten_tomatoes'
    $searchResult = $client->statistics(
        dataset: 'cornell-movie-review-data/rotten_tomatoes',
        split: 'train',
        config: 'default'
    );

    print_r($searchResult);  // Output dataset statistics

} catch (MistralClientException $e) {
    print_r($e);
}
```

---

### Result

```text
Array
(
    [num_examples] => 8530
    [statistics] => Array
        (
            [0] => Array
                (
                    [column_name] => label
                    [column_type] => class_label
                    [column_statistics] => Array
                        (
                            [n_unique] => 2
                            [frequencies] => Array ( [neg] => 4265 [pos] => 4265 )
                            [nan_count] => 0
                            [nan_proportion] => 0
                            [no_label_count] => 0
                            [no_label_proportion] => 0
                        )
                )
            [1] => Array
                (
                    [column_name] => text
                    [column_type] => string_text
                    [column_statistics] => Array
                        (
                            [min] => 4
                            [max] => 267
                            [mean] => 113.97163
                            [median] => 111
                            [std] => 51.05223
                            [histogram] => Array
                                (
                                    [hist] => Array ( [0] => 302 [1] => 955 ... )
                                    [bin_edges] => Array ( [0] => 4 [1] => 31 ... )
                                )
                            [nan_count] => 0
                            [nan_proportion] => 0
                        )
                )
        )
    [partial] =>
)
```

---

### Returned Fields

| Field             | Description                                        |
|-------------------|----------------------------------------------------|
| `num_examples`    | Total number of rows in the dataset split.         |
| `statistics`      | Array of per-column statistics (see below).        |
| `partial`         | Indicates if the statistics are partial.           |

For each **column**:

| Field               | Description                                            |
|---------------------|--------------------------------------------------------|
| `column_name`       | Name of the column (feature).                          |
| `column_type`       | Type of the column (e.g., `class_label`, `string_text`).|
| `column_statistics` | Statistical details for the column (varies by type).   |

---

### Column Types and Statistics

#### Class Labels (e.g., `label`)

| Statistic             | Description                                      |
|-----------------------|--------------------------------------------------|
| `n_unique`            | Number of unique classes.                        |
| `frequencies`         | Count of each class label.                       |
| `nan_count`           | Number of missing values (`NaN`).                 |
| `nan_proportion`      | Proportion of missing values.                     |
| `no_label_count`      | Number of rows without a label (if applicable).   |
| `no_label_proportion` | Proportion of rows without a label.               |

#### Text Fields (e.g., `text`)

| Statistic    | Description                                           |
|--------------|-------------------------------------------------------|
| `min`        | Minimum length of text (in tokens/characters).        |
| `max`        | Maximum length of text.                               |
| `mean`       | Mean (average) length.                                |
| `median`     | Median length.                                        |
| `std`        | Standard deviation of length.                         |
| `histogram`  | Distribution of text lengths (binned histogram).      |
| `nan_count`  | Number of missing values.                             |
| `nan_proportion` | Proportion of missing values.                     |

---

### Use Cases

- **Class imbalance detection**: Check if your dataset labels are balanced.
- **Text field analysis**: Understand length distributions (e.g., for tokenization).
- **Missing data detection**: Identify columns with missing or empty values.
- **Data profiling**: Summarize dataset characteristics before preprocessing.

---

### Common Pitfalls

> [!WARNING]
> - Some datasets may **not support statistics** (e.g., unsupported formats). Use the **Is Valid API** to verify.
> - **Partial statistics** may occur if the dataset is too large or if certain splits are not fully processed.

> [!TIP]
> Leverage **Statistics** to fine-tune **model preprocessing** steps, such as setting token limits or balancing class weights.
