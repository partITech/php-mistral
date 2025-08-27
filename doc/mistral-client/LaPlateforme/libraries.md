# PhpMistral – API **Library** & **DocumentClient**

> Libraries API to create and manage libraries - index your documents to enhance agent capabilities.

---

## Bootstrapping

```php
<?php

// Main client (libraries)
$client = new MistralClient(apiKey: (string) $apiKey);

// Document client (upload, list, status, etc.)
$documentClient = new MistralDocumentClient(apiKey: (string) $apiKey);
```

> With Symfony, register these as services and inject `MISTRAL_API_KEY` through the container.

---

## Libraries

### 1) Create a library

```php
use Partitech\PhpMistral\Clients\Mistral\MistralLibrary;

$name = 'my-library-' . bin2hex(random_bytes(4));
$description = 'php-mistral: docs examples';
$chunkSize = 256; // server-side chunking size

/** @var MistralLibrary $library */
$library = $client->createLibrary(name: $name, description: $description, chunkSize: $chunkSize);

printf("Created library: %s (%s)\n", $library->getName(), $library->getId());
```

### 2) List libraries

```php
$libraries = $client->listLibraries();
foreach ($libraries as $lib) {
    printf("- %s [%s]\n", $lib->getName(), $lib->getId());
}

// Quick access by ID (helper available in the collection)
$libById = $libraries->getById($library->getId());
```

### 3) Update a library

```php
$library->setName('Updated name');
$library->setDescription('Updated description');
$library = $client->updateLibrary($library);
```

### 4) Delete a library

```php
$client->deleteLibrary($library);
```
---

## Documents (DocumentClient)

> All operations below take a **target library** as parameter.

### 1) Upload a document

```php
use Partitech\PhpMistral\Clients\Mistral\MistralDocument;

$file = realpath('./tests/medias/lorem.pdf');
if ($file === false) {
    throw new RuntimeException('Sample file not found.');
}

/** @var MistralDocument $uploaded */
$uploaded = $documentClient->upload($library, $file);

printf("Uploaded: %s (%s)\n", $uploaded->getName() ?? basename($file), $uploaded->getId());
```

### 2) List documents in a library

```php
use Partitech\PhpMistral\Clients\Mistral\MistralDocuments;

/** @var MistralDocuments $docs */
$docs = $documentClient->list($library);

printf("%d document(s) in %s\n", count($docs), $library->getName());
if (count($docs) > 0) {
    $first = $docs->first();
    printf("First doc: %s (%s)\n", $first->getName(), $first->getId());
}
```

### 3) Get a document (by object or ID)

```php
$doc = $documentClient->get($library, $uploaded); // or $documentClient->get($library, $uploaded->getId())
```

### 4) Update document metadata (e.g., name)

```php
$doc->setName('test');
$doc = $documentClient->update($doc);
```

### 5) Track **processing status** & fetch **extracted text**

The API provides:

* `getStatus($document)` → array with `document_id` and `processing_status`.
* `getTextContent($document)` → **string** containing the extracted text (once ready).

```php
$status = $documentClient->getStatus($doc);
print_r($status);

// Active polling until processing finishes
$deadline = time() + 90; // 90s timeout
$ready = false;

while (time() < $deadline) {
    $s = $documentClient->getStatus($doc);
    if (!empty($s['processing_status']) && in_array($s['processing_status'], ['succeeded','failed'], true)) {
        $ready = $s['processing_status'] === 'succeeded';
        break;
    }
    usleep(500_000); // 0.5s
}

if ($ready) {
    $text = $documentClient->getTextContent($doc);
    echo substr($text, 0, 200) . "...\n"; // preview
} else {
    throw new RuntimeException('Processing did not finish within the allotted time.');
}
```

### 6) **Signed URLs** (original file & extracted text)

```php
$signedDocUrl = $documentClient->getSignedUrl($doc);
$signedTextUrl = $documentClient->getExtractedTextSignedUrl($doc);

// Consume with HTTP GET; these are time-limited pre-signed URLs.
```

### 7) **Reprocess** a document

```php
$documentClient->reprocess($doc); // useful after metadata updates or indexing issues
```

### 8) Delete a document

```php
$documentClient->delete($doc);

// Any subsequent retrieval must throw
try {
    $documentClient->get($library, $doc);
    throw new RuntimeException('The document should have been deleted.');
} catch (Throwable $e) {
    // OK – expected
}
```

---

## End‑to‑end example

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Clients\Mistral\MistralDocumentClient;
use Throwable;

$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient(apiKey: (string)$apiKey);
$documentClient = new MistralDocumentClient(apiKey: (string)$apiKey);

try {
    // 1) Create a library
    $library = $client->createLibrary(
        name: 'demo-' . bin2hex(random_bytes(4)),
        description: 'php-mistral: end-to-end demo',
        chunkSize: 256
    );

    // 2) Upload a PDF
    $file = realpath('./tests/medias/lorem.pdf');
    $doc = $documentClient->upload($library, $file);

    // 3) Poll status, then fetch text
    $deadline = time() + 120;
    do {
        $status = $documentClient->getStatus($doc);
        if (($status['processing_status'] ?? null) === 'succeeded') break;
        if (($status['processing_status'] ?? null) === 'failed') {
            throw new RuntimeException('Processing failed');
        }
        usleep(500_000);
    } while (time() < $deadline);

    $text = $documentClient->getTextContent($doc);

    // 4) Rename the document
    $doc->setName('test');
    $doc = $documentClient->update($doc);

    // 5) Signed URLs
    $signedDocUrl = $documentClient->getSignedUrl($doc);
    $signedTextUrl = $documentClient->getExtractedTextSignedUrl($doc);

    // 6) Cleanup
    $documentClient->delete($doc);
    $client->deleteLibrary($library);

    echo "OK – demo completed\n";
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}
```
