# php-json-schema

A PHP implementation of [JSON Schema](http://json-schema.org/). This library allows you to create JSON Schema objects and validate JSON data against them.

# Installation

Install the latest version with

```bash
$ composer require knplabs/php-json-schema
```

# Basic Usage

A JsonSchema must implements `KnpLabs\JsonSchema\JsonSchemaInterface` (which also extends `JsonSerializable`).

## Default JsonSchema

There is already a default implementation of `JsonSchemaInterface` called `KnpLabs\JsonSchema\JsonSchema` which is an abstract class. This class provides some static methods to create some common JSON Schema scalars or objects.

## Scalars

### `JsonSchema::string()`

```php
use KnpLabs\JsonSchema\JsonSchema;

$schema = JsonSchema::create(
    'firstName',                       // The name of the property
    'Hold the first name of the user', // The description of the property
    ['John', 'Georges'],               // Some examples of possible values
    JsonSchema::string()               // The type of the property
);
```

### `JsonSchema::text()`

```php
use KnpLabs\JsonSchema\JsonSchema;

$schema = JsonSchema::create(
    'content',                    // The name of the property
    'The content of the article', // The description of the property
    ['Lorem ipsum...'],           // Some examples of possible values
    JsonSchema::text()            // The type of the property
);
```

### `JsonSchema::integer()`

```php
use KnpLabs\JsonSchema\JsonSchema;

$schema = JsonSchema::create(
    'age',                            // The name of the property
    'Hold the age of the user',       // The description of the property
    [25, 30],                         // Some examples of possible values
    JsonSchema::integer()             // The type of the property
);
```

### `JsonSchema::positiveInteger()`

```php
use KnpLabs\JsonSchema\JsonSchema;

$schema = JsonSchema::create(
    'age',                            // The name of the property
    'Hold the age of the user',       // The description of the property
    [25, 30],                         // Some examples of possible values
    JsonSchema::positiveInteger()     // The type of the property
);
```

### `JsonSchema::number()`

```php
use KnpLabs\JsonSchema\JsonSchema;

$schema = JsonSchema::create(
    'price',                // The name of the property
    'The price in dollars', // The description of the property
    [10.8, 30.0],           // Some examples of possible values
    JsonSchema::number()    // The type of the property
);
```

### `JsonSchema::boolean()`

```php
use KnpLabs\JsonSchema\JsonSchema;

$schema = JsonSchema::create(
    'isAdult',                      // The name of the property
    'Hold if the user is an adult', // The description of the property
    [true, false],                  // Some examples of possible values
    JsonSchema::boolean()           // The type of the property
);
```

### `JsonSchema::date()`

```php
use KnpLabs\JsonSchema\JsonSchema;

$schema = JsonSchema::create(
    'createdAt',                    // The name of the property
    'The date of creation',         // The description of the property
    ['2015-01-01', '2015-01-02'],   // Some examples of possible values
    JsonSchema::date()              // The type of the property
);
```

## Enum

Enum is a special type of scalar which is a list of possible values.
They can be created by extending the `KnpLabs\JsonSchema\EnumSchema`:

```php
<?php

namespace Acme;

use KnpLabs\JsonSchema\EnumSchema;

class RoleEnum extends EnumSchema
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    public function getTitle(): string
    {
        return 'Role enum';
    }

    public function getDescription(): string
    {
        return 'Enum of the possible roles';
    }

    public static function getEnum()
    {
        yield self::ROLE_ADMIN;
        yield self::ROLE_USER;
    }
}
```

## Objects

You can create objects schema by extending the `KnpLabs\JsonSchema\ObjectSchema` class:

```php
<?php

namespace Acme;

use KnpLabs\JsonSchema\ObjectSchema;

/**
 * @extends ObjectSchema<array{
 *   firstName: string,
 *   lastName: string,
 *   role: string,
 * }>
 */
class PersonSchema extends ObjectSchema
{
    public function __construct()
    {
        $this->addProperty(
            'firstName',
            JsonSchema::create(
                'firstName',
                'Hold the first name of the user',
                ['John', 'Georges'],
                JsonSchema::string()
            )
        );

        $this->addProperty(
            'lastName',
            JsonSchema::create(
                'lastName',
                'Hold the last name of the user',
                ['Doe', 'Smith'],
                JsonSchema::string()
            )
        );

        $this->addProperty('role', new RoleEnum());
    }
}
```

## Collections

You can create collections schema by extending the `KnpLabs\JsonSchema\CollectionSchema` class:

```php
<?php

namespace Acme;

use KnpLabs\JsonSchema\CollectionSchema;

class PersonCollectionSchema extends CollectionSchema
{
    public function __construct()
    {
        parent::__construct(new PersonSchema());
    }

    public function getDescription(): string
    {
        return 'The list of all the persons';
    }
}
```