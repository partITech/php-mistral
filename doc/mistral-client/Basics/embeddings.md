# Unified Embeddings API

This document explains the unified embeddings API exposed by the application. It describes:
- How to request embeddings in a provider-agnostic way (same methods across supported clients).
- The EmbeddingCollection and Embedding classes, including their public methods and expected behavior.
- Error handling and batching behavior.

The goal is to keep a consistent developer experience across providers while returning a normalized in-memory representation of embeddings.

Here is a list of compatible clients: 
- Mistral AI La plateforme
- HuggingFace TEI (Text Embeddings Inference)
- LlamaCPP
- Ollama
- Vllm
- Voyage
- Xai
---

## Supported scope

Any client that implements the unified API exposes the same methods to:
- Embed a single text.
- Embed multiple texts (optionally in batches).
- Produce a normalized EmbeddingCollection with Embedding objects.

Notes:
- The concrete client is responsible for calling the provider’s embeddings endpoint and for filling vectors into the returned EmbeddingCollection.
- The unified API hides provider request/response specifics from your application code.

---

## Quick start

### Single text
```php
<?php
// Instantiate the client of your choice that supports the unified embeddings API.
// Replace placeholders with your values.
$client = /* new ...Client( ... ) */;

try {
    $collection = $client->embedText("What is the best French cheese?");
    foreach ($collection->getAll() as $embedding) {
        $id     = $embedding->getId()->toString();
        $text   = $embedding->getText();   // may be null depending on the provider flow
        $vector = $embedding->getVector(); // array of floats
        // use the vector as needed
    }
} catch (Throwable $e) {
    // handle error
}
```
### Multiple texts (optional batching)
```php
<?php
$client = /* new ... */;

$texts = [
    "What is the best French cheese?",
    "How to make Dijon mayonnaise?",
];

// batch: pass null to defer to client defaults, or an integer to force chunk size.
$collection = $client->embedTexts($texts, model: null, batch: 32);

// You can iterate directly (EmbeddingCollection is iterable)
foreach ($collection as $embedding) {
    // ...
}
```
---

## Public API (unified methods)

These methods are made available on compatible clients through a shared trait.

### embedText(string $text, ?string $model = null): EmbeddingCollection
- Purpose: embed a single text.
- Behavior: returns an EmbeddingCollection containing one Embedding. The Embedding will have a generated UUID and its vector filled by the concrete client.
- Model: optionally override the model to use (client-specific).
- Errors: throws an exception if the input text is empty.

### embedTexts(array $texts, ?string $model = null, int $batch = null): EmbeddingCollection
- Purpose: embed multiple texts at once.
- Behavior:
  - Builds an EmbeddingCollection from the given texts.
  - If $batch is provided, it sets the batch size to guide chunking on the client side.
  - Returns a new EmbeddingCollection with vectors filled.
- Model: optionally override the model to use (client-specific).
- Errors: throws an exception if the input list is empty or its first element is empty.

### setBatchSize(?int $batchSize): self and getBatchSize(): ?int
- Purpose: configure/read the default batch size on the client instance exposing the trait.
- Note: batching is effectively applied by the concrete client when building requests.

---

## EmbeddingCollection class

A container for Embedding objects. It is iterable and keyed by Embedding UUIDs (strings).

### Properties (conceptual)
- model: string
- batchSize: ?int
- embeddings: array<string, Embedding> (internal map keyed by UUID string)

### Construction/Population helpers
- add(Embedding $embedding): void
  - Adds an Embedding to the collection (keyed by its UUID).
- setAll(array $embeddings): void
  - Replaces the collection with the given array of Embedding.
  - Throws InvalidArgumentException if any entry is not an Embedding.

### Lookup and access
- getAll(): array
  - Returns the internal array of Embedding keyed by UUID.
- getById(string $id): ?Embedding
  - Returns the Embedding for a UUID, or null.
- removeById(string $id): void
  - Removes the Embedding by UUID.
- getByIds(array $ids): ?EmbeddingCollection
  - Returns a new EmbeddingCollection with items matching the provided UUID list.
- count(): int
  - Number of embeddings in the collection.
- getIterator(): Traversable
  - Enables iteration over the collection (Embedding objects).

### Positional helpers
- getIdByPos(int $pos): string
  - Returns the UUID at the given zero-based position.
- getByPos(int $pos): Embedding
  - Returns the Embedding at the given position (via UUID).
- updateVectorsByPos(int $pos, array $vectors): void
  - Replaces the vector of the Embedding located at the given position.

### Batching helpers
- chunk(?int $batchSize = null): array<EmbeddingCollection>
  - If $batchSize is null, returns an array with this collection only.
  - Otherwise, splits into an array of EmbeddingCollection chunks, preserving model and batchSize.

### Normalization helpers
- arrayAsEmbeddingCollection(array $result): ?EmbeddingCollection
  - Builds and returns a new EmbeddingCollection by reading entries shaped like:
    - ['text' => ?string, 'vector' => array, 'id' => ?string]
  - Preserves current model and batchSize on the new collection.
- fromList(array $result): ?EmbeddingCollection
  - Convenience: converts a string list into a collection of items like ['text' => $value], then delegates to arrayAsEmbeddingCollection.

### Model and batching metadata
- getModel(): string
- setModel(?string $model): EmbeddingCollection
  - Sets the model name to be associated with this collection. Returns self for chaining.
- getBatchSize(): ?int
- setBatchSize(?int $batchSize): EmbeddingCollection
  - Sets an optional batching hint. Returns self for chaining.

---

## Embedding class

Represents a single text embedding payload.

### Properties (conceptual)
- id: UuidInterface
- text: ?string
- vector: array

### Constructor
- __construct(?string $text = null, array|string $vector = [], null|string|UuidInterface $id = null)
  - If $id is null or invalid, a new UUID v4 is generated.
  - $vector may be provided as:
    - array of numbers, or
    - a string formatted like "[...]" or a CSV-like list; it will be parsed into an array.

### Accessors/Mutators
- getId(): UuidInterface
- getText(): ?string
- setText(?string $text): self
- getVector(): array
- setVector(string|array $vector): self
  - Accepts an array or a string; if string, trims surrounding brackets and splits by comma.
- setId(null|string|UuidInterface $id): self
  - If a string is passed, it is parsed as a UUID.
  - If null or not a UUID, a new UUID v4 is generated.

---

## Error handling

- Single text: calling embedText with an empty string throws an exception.
- Multiple texts: calling embedTexts with an empty array or with an empty first item throws an exception.
- Provider-side failures (network, model, quota, input format) are surfaced by the concrete client when executing the request during createEmbeddings.

---

## Batching behavior

- If you pass a $batch value to embedTexts, it is copied to the EmbeddingCollection and used by the concrete client to split requests.
- chunk(...) on EmbeddingCollection returns arrays of EmbeddingCollection chunks, each preserving model and batchSize. This can be leveraged by clients or by advanced consumers.

---

## Output shape (normalized)

- The returned EmbeddingCollection aggregates Embedding instances keyed by UUID.
- Each Embedding contains:
  - id: UUID (string via toString()).
  - text: the original text when available.
  - vector: the embedding vector as an array.

This normalized shape allows consistent handling of embeddings regardless of the provider used by the concrete client.
