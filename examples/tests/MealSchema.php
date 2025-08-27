<?php

use Partitech\PhpMistral\JsonSchema\JsonSchema;

class MealSchema extends \KnpLabs\JsonSchema\ObjectSchema
{
    public function getTitle(): string
    {
        return 'Meal';
    }

    public function getDescription(): string
    {
        return 'The meal composition';
    }

    public function __construct()
    {
        $this->addProperty(
            'type',
            JsonSchema::create(
                'type',
                'Hold the type of meal',
                ['breakfast', 'lunch', 'dinner', 'snack'],
                JsonSchema::text()
            ),
        );

        $yearExample = (new \DateTimeImmutable())->format('Y');
        $this->addProperty(
            'date',
            JsonSchema::create(
                'date',
                'Hold the date of the meal in the Y-M-D format, knowing that today is ' .
                (new \DateTimeImmutable())->format('Y-m-d'),
                [$yearExample . '-05-12', $yearExample . '-10-24', $yearExample . '-12-20'],
                JsonSchema::text()
            ),
        );
    }
}