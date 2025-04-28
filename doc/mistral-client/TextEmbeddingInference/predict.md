## Predict

The `TeiClient` not only supports generating embeddings but also allows you to **run inference tasks** such as sentiment analysis or emotion detection using the `predict()` method.

> [!TIP]
> Use `predict()` when you want to classify text or extract structured predictions (e.g., sentiment, emotion, topic classification), depending on the underlying model served by the TEI endpoint.

### Example: Sentiment/Emotion Analysis

This example demonstrates how to use the `predict()` method to analyze the emotions in a given sentence.

```php
use Partitech\PhpMistral\Clients\Tei\TeiClient;
use Partitech\PhpMistral\MistralClientException;

// Load TEI endpoint for sentiment analysis and API key
$teiUrl = getenv('TEI_SENTIMENT_ANALYSIS_URI');
$apiKey = getenv('TEI_API_KEY');

// Instantiate the TEI client
$client = new TeiClient(apiKey: (string) $apiKey, url: $teiUrl);

try {
    // Perform prediction
    $predictions = $client->predict(inputs: 'I love this product!');
    
    // Display results
    var_dump($predictions);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

#### Output

```text
array(28) {
  [0]=>
  array(2) {
    ["score"]=>
    float(0.9895958)
    ["label"]=>
    string(4) "love"
  }
  [1]=>
  array(2) {
    ["score"]=>
    float(0.004673124)
    ["label"]=>
    string(10) "admiration"
  }
  ...
}
```

The output is an array of **label-score pairs**, where:

- `label` is the predicted category (e.g., emotion like "love", "joy").
- `score` is the confidence of the model in that label (between 0 and 1).

> [!NOTE]
> The specific labels and their meanings depend on the model running at the TEI endpoint. In this example, the model predicts emotions.

---

### Use Cases

- **Emotion Detection**: Classify emotions expressed in text (e.g., love, anger, joy).
- **Sentiment Analysis**: Determine whether a sentence expresses positive, negative, or neutral sentiment.
- **Topic Classification**: Depending on the model, classify text into different topics.

---

### Error Handling

Always handle potential exceptions using `try-catch` to ensure robust applications.

```php
try {
    $result = $client->predict(inputs: "sample input");
} catch (MistralClientException $e) {
    echo $e->getMessage();
}
```

> [!CAUTION]
> Ensure that the TEI endpoint is configured to serve a model capable of prediction tasks (e.g., classification). Using the wrong endpoint may result in errors.

---

### Differences Between `embed()` and `predict()`

| Method     | Purpose                        | Output                                   |
|------------|--------------------------------|------------------------------------------|
| `embed()`  | Generate embeddings (vectors)  | Array of floats (vector representation)  |
| `predict()`| Run inference (classification) | Array of label-score pairs               |

Use `embed()` for semantic vector representations, and `predict()` for extracting structured insights like emotions or sentiments.
