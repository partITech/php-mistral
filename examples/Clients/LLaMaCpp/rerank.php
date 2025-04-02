<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\LlamaCppClient;
use Partitech\PhpMistral\MistralClientException;

$llamacppUrl = getenv('LLAMACPP_URL');   // "self hosted Ollama"
$llamacppApiKey = getenv('LLAMACPP_API_KEY');   // "self hosted Ollama"

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

$documents = [
    "Yoga improves flexibility and reduces stress through breathing exercises and meditation.",
    "Regular yoga practice can help strengthen muscles and improve balance.",
    "A recent study has shown that yoga can lower cortisol levels, the stress hormone.",
    "Yoga and meditation are ancient practices originating from India.",
    "Certain types of yoga, such as Vinyasa, are more dynamic and can improve cardiovascular health.",
    "Yoga helps in improving posture and reducing back pain.",
    "Practicing yoga daily can enhance lung capacity and respiratory function.",
    "Yoga has been linked to better sleep quality and reduced insomnia.",
    "Many people practice yoga to enhance mindfulness and concentration.",
    "Hatha yoga is a gentle form of yoga that is beneficial for beginners.",
    "Some research suggests that yoga can help lower blood pressure.",
    "Yoga is often used as a complementary therapy for anxiety and depression.",
    "Power yoga is an intense workout that can help with weight loss.",
    "Regular yoga practice may improve digestion and gut health.",
    "Certain yoga poses are known to relieve headaches and migraines.",
    "Hot yoga, performed in a heated room, promotes detoxification through sweating.",
    "Prenatal yoga is specifically designed to support pregnant women.",
    "Restorative yoga focuses on deep relaxation and stress relief.",
    "Yoga can improve overall body awareness and coordination.",
    "Studies indicate that yoga may help boost the immune system.",
    "Practicing yoga in the morning can enhance energy levels throughout the day.",
    "Chair yoga is an accessible option for seniors and people with mobility issues.",
    "Some elite athletes incorporate yoga into their training for injury prevention.",
    "Yoga philosophy includes principles of self-discipline and inner peace.",
    "Practicing yoga outdoors can increase vitamin D exposure and mental well-being.",
    "Yoga retreats offer an immersive experience in mindfulness and relaxation.",
    "A well-balanced diet combined with yoga can lead to optimal health benefits.",
    "Mindfulness meditation, often part of yoga, helps develop emotional resilience.",
    "Certain breathing techniques in yoga, like Pranayama, improve focus and calmness.",
    "Yoga promotes a sense of community and connection when practiced in groups.",
    "Practicing yoga regularly can slow down the effects of aging on the body.",
    "Combining yoga with strength training can enhance physical performance.",
    "Yoga has been found to reduce chronic pain in conditions like arthritis and fibromyalgia.",
];
try {
    $rerank = $client->rerank(
        query: "What are the health benefits of yoga?",
        documents: $documents,
        top: 3);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($rerank);
/*
Array
(
    [id] => rerank-a4fb31808ec84add90e5f53bc974959a
    [model] => BAAI/bge-reranker-v2-m3
    [usage] => Array
        (
            [total_tokens] => 891
        )

    [results] => Array
        (
            [0] => Array
                (
                    [index] => 0
                    [document] => Array
                        (
                            [text] => Yoga improves flexibility and reduces stress through breathing exercises and meditation.
                        )

                    [relevance_score] => 0.921875
                )

            [1] => Array
                (
                    [index] => 13
                    [document] => Array
                        (
                            [text] => Regular yoga practice may improve digestion and gut health.
                        )

                    [relevance_score] => 0.8935546875
                )

            [2] => Array
                (
                    [index] => 6
                    [document] => Array
                        (
                            [text] => Practicing yoga daily can enhance lung capacity and respiratory function.
                        )

                    [relevance_score] => 0.873046875
                )

        )

)
 */

