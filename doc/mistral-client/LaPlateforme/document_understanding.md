# Document Understanding with Mistral

This example demonstrates how to leverage **Document Understanding** capabilities in Mistral to process documents such as PDFs, extracting insights or generating summaries by combining textual prompts with document content.

> [!IMPORTANT]
> This functionality allows you to provide **multiple types of input**—textual instructions and document files—enabling rich interactions like summarizing, questioning, or analyzing structured documents.

## Example: Summarize a Document from a URL

This example summarizes a PDF document provided via URL, combining user instructions and the document itself.

```php
use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Message;

// Instantiate the Mistral client with your API key
$client = new MistralClient($apiKey);

// Create a new message with user instruction and document reference
$message = $client->newMessage();
$message->setRole('user');
$message->addContent(
    type: Message::MESSAGE_TYPE_TEXT,
    content: 'Summarize this document.'
);
$message->addContent(
    type: Message::MESSAGE_TYPE_DOCUMENT_URL,
    content: 'https://arxiv.org/pdf/1805.04770'
);

// Add the message to the message list
$messages = $client->getMessages()->addMessage($message);

// Send the request using the chat endpoint
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'mistral-small-latest',  // Selects the inference model
            'max_tokens' => 1024,                // Maximum tokens for the response
            'document_image_limit' => 8,         // Max number of images per document processed
            'document_page_limit' => 64          // Max number of pages per document processed
        ]
    );

    print($result->getMessage());                // Print the summarized result
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

## Key Parameters

| Parameter              | Type    | Description                                                                                          |
|------------------------|---------|------------------------------------------------------------------------------------------------------|
| `model`                | string  | The model to use for document understanding (e.g., `mistral-small-latest`).                          |
| `max_tokens`           | int     | Maximum number of tokens in the generated response.                                                   |
| `document_image_limit` | int     | Maximum number of images processed from the document (for image-based documents).                     |
| `document_page_limit`  | int     | Maximum number of pages from the document that will be processed.                                     |

> [!NOTE]
> **Document Understanding** supports a variety of document types, including PDFs, Word documents, and images (JPEG, PNG, TIFF). When providing a **DOCUMENT_URL**, ensure that the file is publicly accessible.

## Example Output

```text
### Summary of "Born-Again Neural Networks"

**Authors:** Tommaso Furlanello, Zachary C. Lipton, Michael Tschannen, Laurent Itti, Anima Anandkumar

**Abstract:**
Knowledge Distillation (KD) involves transferring knowledge from a high-capacity teacher model to a more compact student model. The authors propose a new perspective on KD by training students with identical architectures to their teachers, resulting in "Born-Again Networks" (BANs) that outperform their teachers. Experiments on DenseNets demonstrate state-of-the-art performance on CIFAR-10 and CIFAR-100 datasets. The study explores two distillation objectives: Confidence-Weighted by Teacher Max (CWTM) and Dark Knowledge with Permuted Predictions (DKPP).

**Introduction:**
The paper revisits KD to disentangle its benefits from model compression. Experiments show that students trained with KD can outperform their teachers, even when both have identical architectures. The authors introduce a simple re-training procedure inspired by Minsky's Sequence of Teaching Selves, where a new student is trained to match the output distribution of the teacher.

**Related Literature:**
The paper reviews KD techniques, focusing on compressing models and improving performance. It highlights the work of Hinton et al. (2015) on dark knowledge and various other KD methods. The authors also discuss the use of KD in deep reinforcement learning and continual learning.

**Born-Again Networks (BANs):**
BANs are based on the idea that the output distribution of a teacher model can provide a rich training signal. The authors explore techniques to modify the loss function with a KD term, addressing cases where the teacher and student networks have identical or similar architectures.

**Experiments:**
Experiments are conducted on CIFAR-10/100 and Penn Tree Bank datasets. BANs consistently outperform their teachers, and the authors explore variations in depth, width, and compression rate. They also demonstrate that KD can improve simpler architectures like ResNets when trained from DenseNet teachers.

**Results:**
BANs show significant improvements over their teachers on CIFAR-10 and CIFAR-100 datasets. The authors also find that BANs can improve language models on the Penn Tree Bank dataset. The study concludes that KD can be used to improve models without relying on strong teachers.

**Discussion:**
The paper draws parallels between the findings and Minsky's concept of a sequence of teaching selves, suggesting that KD can be seen as a form of self-improvement in neural networks.

**Acknowledgements:**
The work was supported by the National Science Foundation, C-BRIC, and the Intel Corporation.

**References:**
The paper cites various works on KD, neural networks, and related fields, providing a comprehensive background for the study.
```

> [!TIP]
> You can adapt the user instruction (e.g., "Summarize this document", "Extract key points", "List important figures") depending on your use case.

## Supported Document Input Types

- `Message::MESSAGE_TYPE_DOCUMENT_URL`: Provide a document via a public URL.
- `Message::MESSAGE_TYPE_DOCUMENT_BASE64`: Embed a document directly as base64 (for non-URL resources).

> [!CAUTION]
> Ensure that the document size and format comply with the Mistral API limitations (e.g., page limits, image limits). Large documents may require adjusting `document_page_limit` or splitting into smaller parts.

## Additional Resources

- [Mistral Document Capabilities Documentation](https://docs.mistral.ai/capabilities/document/)

