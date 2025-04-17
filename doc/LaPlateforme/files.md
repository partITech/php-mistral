## Files

### Upload file

Upload a file that can be used across various endpoints.
The size of individual files can be a maximum of 512 MB. The Fine-tuning API only supports .jsonl files.

#### Parameters
```php
Client::FILE_PURPOSE_FINETUNE
Client::FILE_PURPOSE_BATCH
Client::FILE_PURPOSE_OCR
```
#### Usage

```php
use Partitech\PhpMistral\Clients\Client;use Partitech\PhpMistral\Clients\Mistral\MistralClient;

$client = new MistralClient($apiKey);
// from https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf
$filePath = realpath("./dummy.pdf");
$result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);
```

#### Response
Will return a `\Partitech\PhpMistral\File` object 

```php
Partitech\PhpMistral\File Object
(
    [id:Partitech\PhpMistral\File:private] => Ramsey\Uuid\Lazy\LazyUuidFromString Object
        (
            [unwrapped:Ramsey\Uuid\Lazy\LazyUuidFromString:private] => 
            [uuid:Ramsey\Uuid\Lazy\LazyUuidFromString:private] => 6c9ef298-355d-4159-a95c-1ab0c31a60ed
        )

    [object:Partitech\PhpMistral\File:private] => file
    [bytes:Partitech\PhpMistral\File:private] => 2215244
    [createdAt:Partitech\PhpMistral\File:private] => DateTime Object
        (
            [date] => 2025-03-12 17:38:17.000000
            [timezone_type] => 1
            [timezone] => +00:00
        )

    [filename:Partitech\PhpMistral\File:private] => dummy.pdf
    [purpose:Partitech\PhpMistral\File:private] => ocr
    [sampleType:Partitech\PhpMistral\File:private] => ocr_input
    [numLines:Partitech\PhpMistral\File:private] => 
    [source:Partitech\PhpMistral\File:private] => upload
)
```


## List files

Returns a list of files that belong to the user's organization.

#### Parameters

````php
$query = [
    // Client::FILE_PURPOSE_OCR
    // FILE_PURPOSE_BATCH
    // FILE_PURPOSE_FINETUNE
    'purpose' => Client::FILE_PURPOSE_OCR, 
    'page' => 0,  // int
    'page_size' => 1 // int
    'sample_type' => [], // array of strings
    'source' => [], // array of strings
    'search' => 'my search', // string

]
````

#### Usage
````php
$client = new MistralClient($apiKey);

$query = [
    'purpose' => Client::FILE_PURPOSE_OCR,
    'page' => 0,
    'page_size' => 1
];

try {
    $files = $client->listFiles(query: $query);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

var_dump($files);

foreach ($files as $file) {
    echo $file->getId() . PHP_EOL;
}

````

#### Response

Resoponse is a `\Partitech\PhpMistral\Files` wich is an Iterable class of file.

````php
object(Partitech\PhpMistral\Files)#7 (1) {
  ["files":"Partitech\PhpMistral\Files":private]=>
  object(ArrayObject)#16 (1) {
    ["storage":"ArrayObject":private]=>
    array(1) {
      [0]=>
      object(Partitech\PhpMistral\File)#15 (9) {
        ["id":"Partitech\PhpMistral\File":private]=>
        object(Ramsey\Uuid\Lazy\LazyUuidFromString)#19 (2) {
          ["unwrapped":"Ramsey\Uuid\Lazy\LazyUuidFromString":private]=>
          NULL
          ["uuid":"Ramsey\Uuid\Lazy\LazyUuidFromString":private]=>
          string(36) "6c9ef298-355d-4159-a95c-1ab0c31a60ed"
        }
        ["object":"Partitech\PhpMistral\File":private]=>
        string(4) "file"
        ["bytes":"Partitech\PhpMistral\File":private]=>
        int(2215244)
        ["createdAt":"Partitech\PhpMistral\File":private]=>
        object(DateTime)#22 (3) {
          ["date"]=>
          string(26) "2025-03-12 17:38:17.000000"
          ["timezone_type"]=>
          int(1)
          ["timezone"]=>
          string(6) "+00:00"
        }
        ["filename":"Partitech\PhpMistral\File":private]=>
        string(9) "dummy.pdf"
        ["purpose":"Partitech\PhpMistral\File":private]=>
        string(3) "ocr"
        ["sampleType":"Partitech\PhpMistral\File":private]=>
        string(9) "ocr_input"
        ["numLines":"Partitech\PhpMistral\File":private]=>
        NULL
        ["source":"Partitech\PhpMistral\File":private]=>
        string(6) "upload"
      }
    }
  }
}
````

## Retrieve File

Returns information about a specific file.

#### Parameters

````php

````

#### Usage
````php
$filePath = realpath("./dummy.pdf");
$result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);

try {
    $result = $client->retrieveFile($result->getId()->toString());
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
print_r($result);

````
#### Response

Return a `\Partitech\PhpMistral\File` object
````php
Partitech\PhpMistral\File Object
(
    [id:Partitech\PhpMistral\File:private] => Ramsey\Uuid\Lazy\LazyUuidFromString Object
        (
            [unwrapped:Ramsey\Uuid\Lazy\LazyUuidFromString:private] => 
            [uuid:Ramsey\Uuid\Lazy\LazyUuidFromString:private] => 6c9ef298-355d-4159-a95c-1ab0c31a60ed
        )

    [object:Partitech\PhpMistral\File:private] => file
    [bytes:Partitech\PhpMistral\File:private] => 2215244
    [createdAt:Partitech\PhpMistral\File:private] => DateTime Object
        (
            [date] => 2025-03-12 17:38:17.000000
            [timezone_type] => 1
            [timezone] => +00:00
        )

    [filename:Partitech\PhpMistral\File:private] => dummy.pdf
    [purpose:Partitech\PhpMistral\File:private] => ocr
    [sampleType:Partitech\PhpMistral\File:private] => ocr_input
    [numLines:Partitech\PhpMistral\File:private] => 
    [source:Partitech\PhpMistral\File:private] => upload
)
````

## Delete File
Delete a file.

#### Parameters

````php
// string
$id = '6c9ef298-355d-4159-a95c-1ab0c31a60ed' 
// or an \Ramsey\Uuid\UuidInterface
use Ramsey\Uuid\UuidInterface;
$id = Uuid::fromString('6c9ef298-355d-4159-a95c-1ab0c31a60ed');
````

#### Usage
````php
// Upload a file
$filePath = realpath("./dummy.pdf");
$result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);
$fileId = $result->getId();
echo "uploaded file : " . $fileId->toString(). PHP_EOL;

// Get uploaded file infos
$result = $client->retrieveFile($fileId->toString());
echo "retrieved file : " . $fileId->toString(). PHP_EOL;

// Delete file
$deleted = $client->deleteFile($fileId->toString());
if($deleted === true ){
    echo "file deleted" . PHP_EOL;
}

try {
    $result = $client->listFiles();
    print_r($result);
} catch (Throwable $e) {
    // file not existing anymore.
    echo $e->getMessage();
    exit(1);
}
````
#### Response

Return a boolean. True if scheduled for deletion.


## Download File
Download a file

#### Parameters

````php
// string
$id = '6c9ef298-355d-4159-a95c-1ab0c31a60ed' 
// or an \Ramsey\Uuid\UuidInterface
use Ramsey\Uuid\UuidInterface;
$id = Uuid::fromString('6c9ef298-355d-4159-a95c-1ab0c31a60ed');

// Optionally a destination path string
$destination = realpath('.') . "/downloaded.pdf"
````

#### Usage
````php
// Upload a file
$filePath = realpath("./dummy.pdf");
$result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);
$fileId = $result->getId();
echo "uploaded file : " . $fileId->toString(). PHP_EOL;


try {
    $result = $client->downloadFile(uuid:$fileId, destination: realpath('.') . "/downloaded.pdf" );
    print_r($result);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

````
#### Response

The file content

````php
3002 0 obj
<< /Subtype /Form /BBox [ 33.7954 0 45.0605 -30.0405 ]
/Group 3497 0 R /Length 57 /Matrix [ 1 0 0 1 0 0 ]
/Resources << /ExtGState << /GS0 2796 0 R >> >> >>
stream
0.89 0.467 0.761 rg
/GS0 gs
33.795 0 11.265 -30.041 re
f
endstream
endobj
````

## Get Signed Url
 
Get a valid temporary Url. Default expiration if not set is 24h.
#### Parameters

````php
// string
$id = '6c9ef298-355d-4159-a95c-1ab0c31a60ed' 
// or an \Ramsey\Uuid\UuidInterface
use Ramsey\Uuid\UuidInterface;
$id = Uuid::fromString('6c9ef298-355d-4159-a95c-1ab0c31a60ed');

// Number of hours before the url becomes invalid. Defaults to 24h
$expiry = 24
````

#### Usage
````php
// Upload a file
$filePath = realpath("./dummy.pdf");
$result = $client->uploadFile(path: $filePath, purpose: Client::FILE_PURPOSE_OCR);
$fileId = $result->getId();
echo "uploaded file : " . $fileId->toString(). PHP_EOL;

try {
    $result = $client->getSignedUrl(uuid:$fileId, expiry: 24);
    print_r($result);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
````
#### Response

Return a string Url

````php
https://mistralaifilesapiprodswe.blob.core.windows.net/fine-tune/925b165a-4fa1-4561-8a5e-eff43402fd73/e3fe2c43d27d4c1e959738857c41badf.pdf?se=2025-03-14T12%3A05%3A16Z&sp=r&sv=2025-01-05&sr=b&sig=1LNiVXgLoQ5csOEi7c3KQaTnNSkyzHz9naeCwLqcjwI%3D

````
