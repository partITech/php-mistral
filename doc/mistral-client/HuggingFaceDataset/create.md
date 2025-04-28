## Create

The **Create API** allows you to programmatically create new **Hugging Face repositories** for datasets, models, or spaces. This is useful for automating dataset or model management workflows directly from your PHP applications.

> [!TIP]
> Repositories can be of type **dataset**, **model**, or **space**. Use this method to initialize your Hugging Face project structure before pushing content.

---

### Valid Repository Types

| Constant                                           | Description                    |
|----------------------------------------------------|--------------------------------|
| `HuggingFaceDatasetClient::REPOSITORY_TYPE_MODEL`  | Create a **model** repository. |
| `HuggingFaceDatasetClient::REPOSITORY_TYPE_DATASET`| Create a **dataset** repository.|
| `HuggingFaceDatasetClient::REPOSITORY_TYPE_SPACE`  | Create a **space** (e.g., Gradio or Streamlit app). |

> [!NOTE]
> This example focuses on **datasets**, but the same approach applies to **models** and **spaces**.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');     // Hugging Face API token
$datasetUser = getenv('HF_USER'); // Hugging Face username or organization

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Create a new dataset repository
    $repository = $client->create(
        name: 'rotten_tomatoes',                              // Repository name (without user prefix)
        type: HuggingFaceDatasetClient::REPOSITORY_TYPE_DATASET,  // Repository type
        private: false                                        // Set to true for private repositories
    );

    print_r($repository);  // Display repository details

} catch (MistralClientException $e) {
    print_r($e);  // Handle errors (e.g., if repository already exists)
}
```

---

### Result

```text
Array
(
    [url] => https://huggingface.co/datasets/Bourdin/rotten_tomatoes
    [name] => Bourdin/rotten_tomatoes
    [id] => 68092ce920bd0ac0b4a4f28c
)
```

- **url**: URL to access the repository on Hugging Face.
- **name**: Full repository name (including user or organization prefix).
- **id**: Internal Hugging Face identifier for the repository.

---

### Use Cases

- **Dataset initialization**: Automate the creation of dataset repositories for data pipelines.
- **Model deployment**: Set up model repositories before pushing weights and configurations.
- **Spaces setup**: Automate the provisioning of spaces for interactive apps (e.g., Gradio, Streamlit).

---

### Common Pitfalls

> [!WARNING]
> - The **repository name must be unique** within your Hugging Face account or organization.
> - Ensure your **Hugging Face API token** has the necessary **write permissions**.
> - This API **does not support renaming** repositories. Use Hugging Face's web interface for renames.

> [!CAUTION]
> For **spaces**, make sure the repository contains the necessary configuration files (e.g., `app.py`, `requirements.txt`) to run the app after creation.
