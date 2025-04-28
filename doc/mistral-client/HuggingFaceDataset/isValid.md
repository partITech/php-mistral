## Is Valid

The **Is Valid API** checks whether a **Hugging Face dataset repository** supports specific functionalities, such as:

- **Preview**: Whether the dataset can be previewed on the Hugging Face UI.
- **Viewer**: Whether the dataset has an interactive viewer (e.g., table or file view).
- **Search**: Whether the dataset supports search operations.
- **Filter**: Whether filtering capabilities are available.
- **Statistics**: Whether dataset statistics (e.g., column distributions) are available.

This API helps you **verify compatibility** and **features availability** for a given dataset.

> [!TIP]
> Use this method before integrating with a dataset to ensure it supports the features your application or workflow requires.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');  // Hugging Face API token

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Validate the 'google/civil_comments' dataset
    $isValid = $client->isValid('google/civil_comments');

    print_r($isValid);  // Output dataset capabilities

} catch (MistralClientException $e) {
    print_r($e);
}
```

---

### Result

```text
Array
(
    [preview] => 1
    [viewer] => 1
    [search] => 1
    [filter] => 1
    [statistics] => 1
)
```

- **preview**: Whether the dataset can be previewed in the Hugging Face interface.
- **viewer**: Whether the dataset supports an interactive viewer.
- **search**: Whether search functionality is available.
- **filter**: Whether filtering options are enabled.
- **statistics**: Whether dataset statistics are computed and available.

A value of **1** means the feature is supported; **0** means it is not.

---

### Use Cases

- **Feature detection**: Determine what functionalities are available for a dataset before integrating it into your application.
- **Compatibility checks**: Ensure a dataset supports specific operations (e.g., search, filtering).
- **UI customization**: Adjust your application behavior based on dataset capabilities.

---

### Common Pitfalls

> [!WARNING]
> This API only validates **dataset repositories**. It does **not work with models or spaces**.

> [!NOTE]
> Even if a dataset supports **viewer** or **statistics**, certain features (e.g., search) might depend on the dataset size, format, or structure.
