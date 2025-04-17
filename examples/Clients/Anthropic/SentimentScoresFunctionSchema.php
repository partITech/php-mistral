<?php

use KnpLabs\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\ObjectSchema;

class SentimentScoresFunctionSchema extends ObjectSchema
{
    public function __construct()
    {
        $this->addProperty(
            'positive_score',
            JsonSchema::create(
                'positive_score',
                'The positive sentiment score, ranging from 0.0 to 1.0.',
                [0.9],
                JsonSchema::number()
            ),
            true
        );

        $this->addProperty(
            'negative_score',
            JsonSchema::create(
                'negative_score',
                'The negative sentiment score, ranging from 0.0 to 1.0.',
                [0.1],
                JsonSchema::number()
            ),
            true
        );

        $this->addProperty(
            'neutral_score',
            JsonSchema::create(
                'neutral_score',
                'The neutral sentiment score, ranging from 0.0 to 1.0.',
                [0.5],
                JsonSchema::number()
            ),
            true
        );
    }

    public function getTitle(): string
    {
        return 'print_sentiment_scores';
    }

    public function getDescription(): string
    {
        return 'Prints the sentiment scores of a given text.';
    }

}
