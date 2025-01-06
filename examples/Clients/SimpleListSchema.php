<?php

use KnpLabs\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\ObjectSchema;

class SimpleListSchema extends ObjectSchema
{
    public function __construct()
    {
        $items = JsonSchema::create(
            title: 'List of items',
            description: 'Base on uer query, create a list of items to answer.',
            examples: [
                "200g golden caster sugar",
                "200g unsalted butter, softened plus extra for the tins",
                "4 large eggs",
                "200g self-raising flour",
                "½ tsp vanilla extract",
            ],
            schema: JsonSchema::text()
        );

        $collection = JsonSchema::collection(jsonSchema: $items);
        $this->addProperty(name: 'datas', schema: $collection, required: true);
    }

    public function getTitle(): string
    {
        return 'Simple list';
    }

    public function getDescription(): string
    {
        return 'Analysis of a query and create specific list of answers.';
    }
}