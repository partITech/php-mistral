# Export System
This section explains the role of the export system, the supported formats, the recommended usage flow, and how to add your own formats.
## Why an export system?
Exports are used to transform conversations and/or question/answer pairs into normalized datasets tailored to different AI uses, notably:
- Preparing datasets for fine-tuning or instruction-tuning of models.
- Building datasets for training or evaluating retrievers/rerankers.
- Generating corpora in the format expected by external tools (Sentence Transformers trainers, specific RAG pipelines, etc.).
- Standardizing conversations (Messages) into JSON Lines (JSONL) usable by training scripts.
By centralizing the export logic, you:
- Avoid format-specific errors for each tool.
- Simplify automation (each Messages becomes one JSON line).
- Ensure traceability (metadata preserved, UUID, export type).
---
## Key concepts
- Messages: a normalized multi-turn conversation (roles, contents).
- Chunk/ChunkCollection: segmented text units (chunking) + metadata; each chunk can be converted into one or more Messages conversations.
- ChunkExporter: takes a collection of Messages (or a ChunkCollection) and produces a JSONL output according to a given FormatExporterInterface.
- FormatExporterInterface: contract to implement to define an export format (name + transformation from a Messages to an associative array).
---
## Available export formats
Each export produces one JSON line per Messages conversation. Here’s a recap of the most common formats:
- Alpaca
    - Use: instruction-tuning style “instruction/input/output”.
    - Mapping:
        - instruction: context/general instruction (often the chunk’s text),
        - input: question (user),
        - output: answer (assistant).
- Mistral
    - Use: generic structuring as a list of messages.
    - Mapping:
        - messages: array of objects { role, content }.
- RagatouilleTrainer
    - Use: preparing data for RAG pipelines of the “question + best passage” type with corpus/metadata.
    - Mapping (conceptual example):
        - question: question text,
        - content: { content: selected passage, document_id: string },
        - corpus: global context (e.g., original chunk),
        - uuid: unique identifier,
        - type: exporter name,
        - metadata: additional information (including the Q/A list if present).
- SentenceTransformer
    - Use: training encoders (e.g., bi-encoders) with (question, context) pairs.
    - Mapping:
        - question: first user message,
        - context: first associated assistant response.
> Notes
> - Exporters validate the presence of the minimal required messages (e.g., at least user + assistant).
> - The exact returned fields are normalized to limit downstream errors.
---
## Standard workflow
1) Prepare the content
- You either have a Chunk (text + Q/A in metadata) or already a collection of Messages.
2) Normalize to Messages
- A Chunk converts its data into Messages via its dedicated method.
- A ChunkCollection can contain multiple chunks to convert into multiple conversations.
3) Export to JSON Lines
- Instantiate a ChunkExporter with:
    - An ArrayObject of Messages, or
    - A ChunkCollection (it will be converted automatically).
- Call export() with the targeted exporter (Alpaca, Mistral, etc.).
- The result is a JSONL string, ready to be written to disk.
---
## Example usage

```php
<?php
use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Chunk\QuestionAnswerBase;
use Partitech\PhpMistral\Exporter\ChunkExporter;
use Partitech\PhpMistral\Exporter\Formats\AlpacaFormatExporter;
use Partitech\PhpMistral\Exporter\Formats\MistralFormatExporter;
use Partitech\PhpMistral\Exporter\Formats\RagatouilleTrainer;
use Partitech\PhpMistral\Exporter\Formats\SentenceTransformerTrainerExporter;
// 1) Build a chunk with context + Q/A
$chunk = new Chunk();
$chunk->setText('...your context...');
$qa = (new QuestionAnswerBase())
    ->setQuestion('Your question?')
    ->setAnswer('Your answer.');
$chunk->addToMetadata(Chunk::METADATA_KEY_QNA, $qa);
// 2) Convert to Messages conversations
$messagesCollection = $chunk->toMessages();
// 3) Export using the desired format
$exporter = new ChunkExporter($messagesCollection);
// Alpaca
$alpacaJsonl = $exporter->export(new AlpacaFormatExporter());
// Mistral (messages role/content)
$mistralJsonl = $exporter->export(new MistralFormatExporter());
// Ragatouille (question + passage + corpus + metadata)
$ragJsonl = $exporter->export(new RagatouilleTrainer());
// SentenceTransformer (question + context)
$stJsonl = $exporter->export(new SentenceTransformerTrainerExporter());
// 4) Persist to file if needed
file_put_contents('/path/to/dataset_alpaca.jsonl', $alpacaJsonl);
```
## Export Examples formats :
### Mistral
```json
{
  "messages" : [ {
    "role" : "user",
    "content" : "What is Lorem Ipsum?"
  }, {
    "role" : "assistant",
    "content" : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
  } ]
}
```

### Alpaca
```json
{
  "instruction" : "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed elementum enim. Curabitur viverra sapien dignissim nisl rutrum lobortis. Pellentesque pellentesque arcu vitae tortor vehicula placerat. In sed metus ante. Nullam neque tellus, molestie et eleifend interdum, ullamcorper at urna. Duis id libero feugiat velit posuere scelerisque ut non nisl. In gravida ante massa, nec placerat urna varius id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis eu leo sit amet mauris porta malesuada id eu magna. Vivamus ut neque quis odio ultrices posuere. Morbi eget odio id eros dictum dignissim eget eu velit. Suspendisse luctus elit eget nulla tempus volutpat. Phasellus facilisis nulla ex, tempor aliquam diam fringilla a. Aliquam erat erat, pellentesque at metus eget, sollicitudin lobortis erat.",
  "input" : "What is Lorem Ipsum?",
  "output" : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
}
```

### RagatouilleTrainer
```json
{
  "question" : "What is Lorem Ipsum?",
  "content" : {
    "content" : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
    "document_id" : "01990fbb-4328-7258-9f90-1f841a022828"
  },
  "corpus" : "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed elementum enim. Curabitur viverra sapien dignissim nisl rutrum lobortis. Pellentesque pellentesque arcu vitae tortor vehicula placerat. In sed metus ante. Nullam neque tellus, molestie et eleifend interdum, ullamcorper at urna. Duis id libero feugiat velit posuere scelerisque ut non nisl. In gravida ante massa, nec placerat urna varius id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis eu leo sit amet mauris porta malesuada id eu magna. Vivamus ut neque quis odio ultrices posuere. Morbi eget odio id eros dictum dignissim eget eu velit. Suspendisse luctus elit eget nulla tempus volutpat. Phasellus facilisis nulla ex, tempor aliquam diam fringilla a. Aliquam erat erat, pellentesque at metus eget, sollicitudin lobortis erat.",
  "uuid" : "01990fbb-4330-72d5-ac11-8aebd81f90f5",
  "type" : "ragatouilleTrainer",
  "metadata" : {
    "uuid" : "01990fbb-4328-7258-9f90-1f841a022828",
    "qna" : [ {
      "question" : "What is Lorem Ipsum?",
      "answer" : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
    }, {
      "question" : "Why do we use it?",
      "answer" : "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
    }, {
      "question" : "Where does it come from?",
      "answer" : "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32."
    }, {
      "question" : "Where can I get some?",
      "answer" : "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc."
    } ]
  }
}
```

### SentenceTransformer
```json
{
  "question" : "What is Lorem Ipsum?",
  "context" : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
}
```

---
## Best practices
- Validate Q/A pairs
    - Ensure you have at least one “user” then “assistant” turn for formats that require it (Alpaca, SentenceTransformer).
- Minimal cleanup
    - Avoid empty content: normalize spaces, remove empty blocks.
- Keep useful metadata
    - UUID, chunk index, document provenance: very useful for replication or auditing results.
- One JSONL per line
    - Each Messages must generate a standalone JSON line. Avoid multi-line structures if you post-process with CLI tools.
- Test your exports
    - Before a long training run, sample a few JSONL lines and verify compatibility with your pipeline.
---
## Error handling
- Size validation
    - Some exporters require at least two messages (question + answer). An exception is thrown if the condition is not met.
- Message types
    - Exporters support both Message objects and array structures {role, content}, but ignore invalid elements.
- Non-text content
    - When the target format requires strings, non-convertible content triggers an exception to avoid an inconsistent dataset.
Tip: For large batches, wrap the export in a try/catch and log rejected items; this simplifies troubleshooting corrupted entries.
---
## Add a new export format
To support an external tool, implement a dedicated exporter:
1) Implement the interface
- Create a class that implements FormatExporterInterface.
- Provide:
    - getName(): short, stable identifier (e.g., "myTool"),
    - export(Messages $messages): transform into an associative array.
2) Map the fields
- Extract useful roles and contents from Messages.
- Structure the output according to the target tool’s contract.
3) Integrate into the pipeline
- Use ChunkExporter as you would for existing formats.
- Each Messages becomes an encodable JSON line.
Minimal example:
```
php
<?php
use Partitech\PhpMistral\Interfaces\FormatExporterInterface;
use Partitech\PhpMistral\Messages;
final class MyToolExporter implements FormatExporterInterface
{
    public function getName(): string
    {
        return 'myTool';
    }
    public function export(Messages $messages): array
    {
        // Example: take the first user and the first assistant
        $user = null;
        $assistant = null;
        foreach ($messages->getMessages() as $m) {
            $role = method_exists($m, 'getRole') ? $m->getRole() : ($m['role'] ?? null);
            $content = method_exists($m, 'getContent') ? $m->getContent() : ($m['content'] ?? null);
            if ($role === Messages::ROLE_USER && $user === null) {
                $user = (string)$content;
            } elseif ($role === Messages::ROLE_ASSISTANT && $assistant === null) {
                $assistant = (string)$content;
            }
            if ($user !== null && $assistant !== null) {
                break;
            }
        }
        if ($user === null || $assistant === null) {
            throw new \InvalidArgumentException('MyTool export requires a user question and an assistant answer.');
        }
        return [
            'prompt' => $user,
            'response' => $assistant,
            'type' => $this->getName(),
        ];
    }
}
```
---
## Typical use cases
- Fine-tuning (instruction-tuning)
    - Export to Alpaca to quickly build an instruction/input/output dataset.
- Retriever evaluation and training
    - Export to SentenceTransformer for (question, context) pairs.
- Production-oriented RAG
    - Export to RagatouilleTrainer to link question, selected passage, corpus, and metadata.
---
## Pre-training checklist
- Balanced data: variety of questions/answers.
- Linguistic quality: limit noise and repetition.
- Traceability: keep document_id, uuid, chunk indices.
- Validation: sample 50–100 lines to verify schema and parsing.
