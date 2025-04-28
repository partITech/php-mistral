## Pixtral: Vision Model Integration

Pixtral is Mistral's **multimodal model** capable of processing both **text** and **images**. Interacting with Pixtral is similar to a standard chat, but requires **image inputs** alongside text prompts.

You simply need to:
1. Use a vision-capable model like `pixtral-12b-2409`.
2. Construct a **Message** object that combines:
   - Text (`MESSAGE_TYPE_TEXT`)
   - Image URLs (`MESSAGE_TYPE_IMAGE_URL`)
   - Local images in base64 (`MESSAGE_TYPE_BASE64`)

> [!TIP]
> This allows flexible input handling:
> - Use **URLs** for hosted images.
> - Use **base64** for local files (e.g., charts, diagrams).
> - Combine **multiple images and texts** for complex prompts.

---

### Example: Describe Multiple Images

```php
use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Message;

$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$message = $client->newMessage();
$message->setRole('user');

// Add initial text prompt
$message->addContent(
    type: Message::MESSAGE_TYPE_TEXT,
    content: 'Describe this image in detail please.'
);

// Add first image via URL
$message->addContent(
    type: Message::MESSAGE_TYPE_IMAGE_URL,
    content: 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg'
);

// Add follow-up text
$message->addContent(
    type: Message::MESSAGE_TYPE_TEXT,
    content: 'And these two images as well. Answer in French.'
);

// Add second image via URL
$message->addContent(
    type: Message::MESSAGE_TYPE_IMAGE_URL,
    content: 'https://www.wolframcloud.com/obj/resourcesystem/images/a0e/a0ee3983-46c6-4c92-b85d-059044639928/6af8cfb971db031b.png'
);

// Add third image via local file (base64)
$message->addContent(
    type: Message::MESSAGE_TYPE_BASE64,
    content: realpath('./../../medias/pixtral_image_example_charts.jpeg')
);

$messages = $client->getMessages()->addMessage($message);
```

---

### Send to the Pixtral Model

```php
try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'pixtral-12b-2409',
            'max_tokens' => 1024,
        ]
    );
} catch (\Partitech\PhpMistral\MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());
```

---

### Sample Output (Translated in French)

```text
### Description des Images

#### Première Image
Trois personnes courent dans un cadre naturel, souriantes et concentrées, entourées de verdure.

#### Deuxième Image
Une famille de cinq personnes, portant des chemises rouges, posant devant un fond blanc.

#### Troisième Image
Un graphique comparant les indicateurs socio-économiques entre les zones défavorisées et la France entière :
- **Classe ouvrière** : 33,5 % vs 14,5 %
- **Chômage** : 18,1 % vs 7,3 %
- **Jeunes sans emploi** : 25,2 % vs 12,9 %
- **Revenu médian** : 1 168 € vs 1 822 €
- **Pauvreté** : 43,3 % vs 15,5 %
```

> [!IMPORTANT]
> Pixtral excels at **image captioning**, **chart analysis**, and **complex multimodal tasks**.
> Make sure your image URLs are **publicly accessible** or use **base64** for local files.