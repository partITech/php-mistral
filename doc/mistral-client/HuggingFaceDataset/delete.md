## Delete

The **Delete API** allows you to permanently remove a **repository** (dataset, model, or space) from your **Hugging Face account** or organization.

> [!CAUTION]
> Once the payload is sent, there is **no going back**—the repository will be **immediately deleted**, and **all associated files will be permanently lost**.  
> Ensure you have backups or are certain before performing this operation.

---

### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');     // Hugging Face API token
$datasetUser = getenv('HF_USER'); // Hugging Face username or organization

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

try {
    // Delete the 'rotten_tomatoes' dataset repository
    $repository = $client->delete(
        name: 'rotten_tomatoes',                                   // Repository name (without user prefix)
        type: HuggingFaceDatasetClient::REPOSITORY_TYPE_DATASET    // Repository type (dataset, model, or space)
    );

    print_r($repository);  // Should output 'OK' if successful

} catch (MistralClientException $e) {
    print_r($e);  // Handle errors (e.g., repository not found)
}
```

---

### Result

```text
OK
```

- **OK**: Indicates that the repository has been successfully deleted from Hugging Face.

---

### Use Cases

- **Cleanup**: Remove obsolete or test repositories.
- **Automated workflows**: Integrate repository deletion into your CI/CD pipelines or data lifecycle management.

---

### Common Pitfalls

> [!WARNING]
> - **Deleted repositories cannot be recovered**.
> - The **Hugging Face API token** must have appropriate **admin or write permissions** to perform deletions.
> - Ensure you specify the **correct repository name and type** to avoid accidental deletions.

> [!TIP]
> Always perform a **health check** (e.g., list repositories) before deletion to confirm the target exists.
