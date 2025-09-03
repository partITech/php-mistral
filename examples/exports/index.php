<?php

use Partitech\PhpMistral\Chunk\Chunk;
use Partitech\PhpMistral\Chunk\QuestionAnswerBase;
use Partitech\PhpMistral\Exporter\ChunkExporter;
use Partitech\PhpMistral\Exporter\Formats\AlpacaFormatExporter;
use Partitech\PhpMistral\Exporter\Formats\MistralFormatExporter;
use Partitech\PhpMistral\Exporter\Formats\RagatouilleTrainer;
use Partitech\PhpMistral\Exporter\Formats\SentenceTransformerTrainerExporter;

require_once __DIR__ . '/../../vendor/autoload.php';

$chunk = new Chunk();
// Add context to messages series.
$chunk->setText(
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed elementum enim. Curabitur viverra sapien dignissim nisl rutrum lobortis. Pellentesque pellentesque arcu vitae tortor vehicula placerat. In sed metus ante. Nullam neque tellus, molestie et eleifend interdum, ullamcorper at urna. Duis id libero feugiat velit posuere scelerisque ut non nisl. In gravida ante massa, nec placerat urna varius id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis eu leo sit amet mauris porta malesuada id eu magna. Vivamus ut neque quis odio ultrices posuere. Morbi eget odio id eros dictum dignissim eget eu velit. Suspendisse luctus elit eget nulla tempus volutpat. Phasellus facilisis nulla ex, tempor aliquam diam fringilla a. Aliquam erat erat, pellentesque at metus eget, sollicitudin lobortis erat.'
);

$qna1 = new QuestionAnswerBase();
$qna1->setQuestion(question: 'What is Lorem Ipsum?');
$qna1->setAnswer(
    "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
);

$qna2 = new QuestionAnswerBase();
$qna2->setQuestion(question: 'Why do we use it?');
$qna2->setAnswer(
    "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
);

$qna3 = new QuestionAnswerBase();
$qna3->setQuestion(question: 'Where does it come from?');
$qna3->setAnswer(
    "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32."
);

$qna4 = new QuestionAnswerBase();
$qna4->setQuestion(question: 'Where can I get some?');
$qna4->setAnswer(
    "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc."
);

$chunk->addToMetadata(
    Chunk::METADATA_KEY_QNA,
    $qna1
);
$chunk->addToMetadata(
    Chunk::METADATA_KEY_QNA,
    $qna2
);
$chunk->addToMetadata(
    Chunk::METADATA_KEY_QNA,
    $qna3
);
$chunk->addToMetadata(
    Chunk::METADATA_KEY_QNA,
    $qna4
);


$messagesCollection = $chunk->toMessages();
$exporter           = new ChunkExporter($messagesCollection);


try {
    $jsonLines = $exporter->export(new AlpacaFormatExporter());
} catch (JsonException $e) {
    exit($e->getMessage());
}

echo $jsonLines;
/*
{
  "instruction" : "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed elementum enim. Curabitur viverra sapien dignissim nisl rutrum lobortis. Pellentesque pellentesque arcu vitae tortor vehicula placerat. In sed metus ante. Nullam neque tellus, molestie et eleifend interdum, ullamcorper at urna. Duis id libero feugiat velit posuere scelerisque ut non nisl. In gravida ante massa, nec placerat urna varius id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis eu leo sit amet mauris porta malesuada id eu magna. Vivamus ut neque quis odio ultrices posuere. Morbi eget odio id eros dictum dignissim eget eu velit. Suspendisse luctus elit eget nulla tempus volutpat. Phasellus facilisis nulla ex, tempor aliquam diam fringilla a. Aliquam erat erat, pellentesque at metus eget, sollicitudin lobortis erat.",
  "input" : "What is Lorem Ipsum?",
  "output" : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
}

 */
try {
    $jsonLines = $exporter->export(new MistralFormatExporter());
} catch (JsonException $e) {
    exit($e->getMessage());
}

echo $jsonLines;

/*
{
  "messages" : [ {
    "role" : "user",
    "content" : "What is Lorem Ipsum?"
  }, {
    "role" : "assistant",
    "content" : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
  } ]
}
 */

try {
    $jsonLines = $exporter->export(new RagatouilleTrainer());
} catch (JsonException $e) {
    exit($e->getMessage());
}

echo $jsonLines;

/*
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
 */
try {
    $jsonLines = $exporter->export(new SentenceTransformerTrainerExporter());
} catch (JsonException $e) {
    exit($e->getMessage());
}

echo $jsonLines;
/*
{
  "question" : "What is Lorem Ipsum?",
  "context" : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
}
 */
