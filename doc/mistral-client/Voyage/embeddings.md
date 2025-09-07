## Embeddings

> [!IMPORTANT]
> This method is specific to this service inference.
> You should consider using the [Unified embedding documentation](../Basics/embeddings.md) for more information.


The **embeddings** method allows you to generate vector representations of text inputs. 
These embeddings are numerical representations capturing the semantic meaning of the input text and are commonly used for tasks like semantic search,
clustering, or as input features for machine learning models.

> [!NOTE]
> This example demonstrates how to use the embeddings with VoyageAi service 

---

### Example

This example generates embeddings for the input sentence "What is the best French cheese?" using the `BAAI/bge-m3` embedding model.

```php
use Partitech\PhpMistral\Clients\Voyage\VoyageClient;
use Partitech\PhpMistral\Embeddings\EmbeddingCollection;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('VOYAGE_API_KEY');
$client = new VoyageClient(apiKey: (string) $apiKey);

$inputs = [];

for($i=0; $i<10; $i++) {
    $inputs[] = "$i : What is the best French cheese?";
}

$result = $client->embedText(text: 'test', model:'voyage-law-2');
$test = $result;

$result = $client->embedTexts(texts: $inputs, model:'voyage-law-2', batch: 3);
$test = $result;


$embeddingCollection = (new EmbeddingCollection())
    ->fromList($inputs)
    ->setModel('voyage-law-2')
    ->setBatchSize(3);
$result = $client->createEmbeddings($embeddingCollection);
```