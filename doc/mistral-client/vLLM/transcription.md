# Audio Transcription with vLLM

This example demonstrates how to **transcribe audio files** into text using the **transcription API** of **vLLM** through the `PhpMistral` library.

The transcription process sends an audio file (e.g., `.mp3`, `.wav`) to a model like **Whisper** and retrieves the corresponding text output.

> [!NOTE]
> This feature is available in vLLM servers configured with a **transcription model** (such as OpenAI's Whisper family).

---

## Example Code

```php
use Partitech\PhpMistral\Clients\Vllm\VllmClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('VLLM_API_KEY');   // Your vLLM token
$urlApiTranscription = getenv('VLLM_API_TRANSCRIPTION_URL'); // vLLM transcription endpoint
$transcriptionModel  = getenv('VLLM_API_TRANSCRIPTION_MODEL'); // e.g., 'openai/whisper-small'

$client = new VllmClient(apiKey: (string) $apiKey, url: $urlApiTranscription);

// Path to the audio file to transcribe
$path = realpath("./../../medias/mit.mp3");

try {
    $response = $client->transcription(
        path: $path,
        model: $transcriptionModel
    );
    print_r($response);
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}
```

---

## Example Output

```text
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files.
```

---

## Parameters

| Parameter      | Type   | Description                                                        |
|----------------|--------|--------------------------------------------------------------------|
| `path`         | string | Full path to the audio file. Supported formats depend on the model.|
| `model`        | string | Name of the transcription model (e.g., `openai/whisper-small`).    |

---

## Supported Models

This endpoint works with **transcription models** deployed on your vLLM server. Example models include:

- `openai/whisper-small`
- `openai/whisper-medium`
- `openai/whisper-large`

Refer to the [vLLM transcription models documentation](https://docs.vllm.ai/en/latest/models/transcription_models.html) for a full list.

> [!TIP]
> The **Whisper** models from OpenAI are trained to handle multiple languages and various audio formats.

---

## Use Cases

- Transcribe **interviews**, **meetings**, or **lectures** into text.
- Process **podcasts** or **voice notes** for documentation or analysis.
- Enable **speech-to-text** functionalities in your applications.

> [!CAUTION]
> Ensure that the vLLM server is configured with transcription capabilities and supports the chosen model.
