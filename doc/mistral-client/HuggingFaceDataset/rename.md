## Rename

The **Rename API** allows you to **change the name of an existing Hugging Face repository** (dataset, model, or space). This operation updates the repository’s identifier (URL) without losing its content or history.

> [!WARNING]
> Renaming a repository **changes its public URL**. Make sure to update any links or integrations relying on the old name.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');       // Hugging Face API token
$datasetUser = getenv('HF_USER');   // Hugging Face username or organization

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Rename the 'test2' dataset repository to 'test3'
    $status = $client->rename(
        from: $datasetUser . '/test2',                                // Current repository name (user/repo)
        to: $datasetUser . '/test3',                                  // New repository name (user/repo)
        type: HuggingFaceDatasetClient::REPOSITORY_TYPE_DATASET       // Repository type (dataset, model, or space)
    );

    print_r($status);  // Should output 'OK' if successful

} catch (MistralClientException $e) {
    print_r($e);  // Handle errors (e.g., repository not found, new name already taken)
}
```

---

### Result

```text
OK
```

- **OK**: The repository was successfully renamed.

---

### Use Cases

- **Rebranding**: Update repository names to align with new project or organizational naming conventions.
- **Versioning**: Rename old repositories for archival purposes and free up names for newer versions.
- **Correction**: Fix typos or improve clarity in repository names.

---

### Common Pitfalls

> [!CAUTION]
> - After renaming, the **repository’s previous URL becomes invalid**. Ensure you update:
    >   - **Documentation**
>   - **CI/CD pipelines**
>   - **External links** (e.g., websites, notebooks)
>
> - The **new repository name must be unique** within your Hugging Face account or organization.

> [!TIP]
> Use the **List by author** API to verify existing repository names before attempting a rename.
