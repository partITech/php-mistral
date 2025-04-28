## Commit

The **Commit API** allows you to push local dataset files to a **Hugging Face repository** using **Git** and **Git LFS**. This process leverages the PHP package [`czproject/git-php`](https://github.com/czproject/git-php) for managing Git operations programmatically.

> [!IMPORTANT]
> You **must have Git and Git LFS installed** on your system to use this feature, as well as the PHP package `czproject/git-php`. Ensure these tools are correctly configured and accessible in your system's PATH.

---

### Prerequisites

1. **Git**: Installed and configured globally.
2. **Git LFS**: Installed and configured (`git lfs install`).
3. **Hugging Face Token**: An API token with write access to the target repository.
4. **czproject/git-php**: Installed via Composer:
   ```bash
   composer require czproject/git-php
   ```

---

### Code

```php
$apiKey = getenv('HF_TOKEN');    // Hugging Face API token
$hfUser = getenv('HF_USER');     // Your Hugging Face username or organization

$client = new HuggingFaceDatasetClient(apiKey: (string) $apiKey);

// Get the list of files from a local directory (e.g., your dataset folder)
$files = $client->listFiles('./dir');

try {
    // Commit and push the files to the Hugging Face dataset repository
    $commit = $client->commit(
        repository: $hfUser . '/test2',        // Target repository (user/repo)
        dir: realpath('mon_dataset'),          // Local directory containing dataset files
        files: $files,                         // Files to commit (list of relative paths)
        summary: 'commit title',               // Commit summary (short description)
        commitMessage: 'commit message',       // Full commit message
        branch: 'main'                         // Branch to commit to (default: main)
    );

    print_r($commit);  // Display commit details

} catch (\Throwable $e) {
    print_r($e);  // Handle any errors during the commit process
}
```

---

### Result

```text
Array
(
    [repository] => USER/test2
    [branch] => main
    [commit_message] => commit message
    [files] => Array
        (
            [0] => .gitattributes
            [1] => data/validation-00000-of-00001.parquet
            [2] => data/test-00000-of-00001.parquet
            [3] => data/train-00001-of-00002.parquet
            [4] => data/train-00000-of-00002.parquet
            [5] => README.md
        )
)
```

- **repository**: The Hugging Face repository where the dataset was pushed.
- **branch**: The branch where the commit was made.
- **commit_message**: The message associated with the commit.
- **files**: List of files included in the commit.

> [!TIP]
> The `.gitattributes` file is automatically managed to ensure proper handling of **Git LFS** for large files (e.g., `.parquet`, `.csv`, etc.).

---

### Use Cases

- **Dataset versioning**: Manage different versions of datasets directly from your PHP applications.
- **Automated data pipelines**: Integrate dataset pushes into your CI/CD workflows.
- **Collaborative datasets**: Easily share and update datasets on Hugging Face.

---

### Common Pitfalls

> [!WARNING]
> - Ensure **Git** and **Git LFS** are properly installed and initialized (`git lfs install`).
> - The Hugging Face **API token** must have the necessary permissions (write access to the repository).
> - The target **repository must exist** on Hugging Face before committing. This API does not create repositories.

> [!CAUTION]
> Large files (e.g., datasets) are managed via **Git LFS**. If LFS is not configured correctly, pushing large files may fail.

