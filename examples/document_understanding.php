<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;
use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\Message;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$message = new Message();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT,   content: 'Resume this document.');
$message->addContent(type: Message::MESSAGE_TYPE_DOCUMENT_URL,    content: 'https://arxiv.org/pdf/1805.04770');

$messages = new Messages();
$messages->addMessage($message);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'mistral-small-latest',
            'max_tokens' => 1024,
            'document_image_limit' => 8,
            'document_page_limit'   => 64
        ]
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());
/*
### Resume of the Document

**Title: Born-Again Neural Networks**

**Authors:**
- Tommaso Furlanello
- Zachary C. Lipton
- Michael Tschannen
- Laurent Itti
- Anima Anandkumar

**Abstract:**
The paper introduces the concept of Born-Again Networks (BANs), which involves training neural networks (students) using the outputs of previously trained networks (teachers) of identical architecture. Surprisingly, these BANs outperform their teachers in various tasks, including computer vision and language modeling. The study explores different distillation objectives and demonstrates that BANs achieve state-of-the-art performance on datasets like CIFAR-10 and CIFAR-100.

**Introduction:**
The paper revisits the concept of Knowledge Distillation (KD), traditionally used for model compression, and proposes a new approach where students are trained to mimic their teachers of identical capacity. This method, inspired by Breiman's ensemble techniques and Minsky's teaching selves, shows that students can outperform their teachers.

**Related Literature:**
The paper reviews related work on KD and model compression, highlighting the evolution from early methods to recent advancements in deep learning. It also discusses the use of KD in various domains, including reinforcement learning and continual learning.

**Born-Again Networks (BANs):**
BANs are trained using a combination of true labels and the teacher's output distribution. The gradient induced by KD is decomposed into dark knowledge and ground-truth components. The paper explores different distillation objectives, such as Confidence-Weighted by Teacher Max (CWTM) and Dark Knowledge with Permuted Predictions (DKPP), to understand the essential components of KD.

**Experiments:**
Experiments are conducted on CIFAR-10, CIFAR-100, and Penn Tree Bank datasets. BANs demonstrate significant improvements over their teachers across different architectures, including DenseNets and ResNets. The paper also explores the effect of varying network depth, width, and compression rates, as well as the impact of removing dark knowledge components.

**Results:**
BANs consistently outperform their teachers in various configurations. For instance, BAN-DenseNets achieve lower validation errors on CIFAR-10 and CIFAR-100 datasets. The sequence of teaching selves and ensembles of BANs further improve performance. The removal of dark knowledge components still yields improvements, indicating the robustness of the BAN approach.

**Discussion:**
The paper discusses the implications of the BAN approach, drawing parallels with Minsky's Society of Mind. It concludes that the transfer of knowledge between identical networks can lead to significant performance gains, challenging the conventional wisdom of model compression.

**Acknowledgements:**
The work was supported by various institutions and grants, including the National Science Foundation and Intel Corporation.

**References:**
The paper cites numerous works related to KD, model compression, and deep learning, providing a comprehensive overview of the relevant literature.
*/