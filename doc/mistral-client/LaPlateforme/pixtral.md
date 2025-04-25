## Pixtral

Using the mistral vision model il slightly the same as a regular chat message. 
You will need to specify an image model like `pixtral-12b-2409` and construct a specific user Message with your content images. 

This Message object can have `text`, `url` and `base64`.

here is a concrete example: 


```php
use Partitech\PhpMistral\Clients\Mistral\MistralClient;
use Partitech\PhpMistral\Message;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

$message = $client->newMessage();
$message->setRole('user');
$message->addContent(
    type: Message::MESSAGE_TYPE_TEXT, 
    content: 'Describe this image in detail please.'
);
$message->addContent(
    type: Message::MESSAGE_TYPE_IMAGE_URL, 
    content: 'https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg'
);
$message->addContent(
    type: Message::MESSAGE_TYPE_TEXT, 
    content: 'and theses two images as well. Answer in French.'
);
$message->addContent(
    type: Message::MESSAGE_TYPE_IMAGE_URL, 
    content: 'https://www.wolframcloud.com/obj/resourcesystem/images/a0e/a0ee3983-46c6-4c92-b85d-059044639928/6af8cfb971db031b.png'
);
$message->addContent(
    type: Message::MESSAGE_TYPE_BASE64, 
    content: realpath('./../../medias/pixtral_image_example_charts.jpeg')
);
$messages = $client
    ->getMessages()
    ->addMessage($message);
```

Now you can use the `Messages` object in your `MistralClient::chat()` method.

```php

use Partitech\PhpMistral\MistralClient;
use Partitech\PhpMistral\MistralClientException;

$client = new MistralClient($apiKey);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'pixtral-12b-2409',
            'max_tokens' => 1024,
        ]
    );
} catch (MistralClientException $e) {
    echo $e->getMessage();
    exit(1);
}

print($result->getMessage());
```


The result will be the descriptions of the three images provided : 

```text
### Description des Images

#### Première Image
L'image montre trois personnes en train de courir dans un cadre naturel. Les deux femmes et un homme sont vêtus de tenues de sport décontractées. La femme à gauche porte un t-shirt vert et un short noir, la femme à droite porte un t-shirt rose et un legging noir, et l'homme porte un t-shirt gris et un short noir. Ils semblent tous les trois être en pleine foulée, avec des expressions joyeuses et concentrées. L'arrière-plan est une forêt luxuriante avec des arbres et des buissons verts, suggérant qu'ils courent dans un parc ou une forêt.

#### Deuxième Image
Cette image représente une famille de cinq personnes posant pour une photo. Ils sont tous vêtus de chemises rouges assorties et sont assis sur le sol, les mains jointes devant eux. La famille comprend deux adultes et trois enfants. Les deux adultes sourient, et les enfants semblent également heureux et détendus. L'arrière-plan est blanc uni, ce qui met l'accent sur la famille.

#### Troisième Image
Cette image est un graphique intitulé "La Division Sociale de la France". Il compare divers indicateurs socio-économiques entre les zones défavorisées et la France dans son ensemble. Les indicateurs incluent :
- **Part des personnes faisant partie de la classe ouvrière** : 33,5 % dans les zones défavorisées contre 14,5 % dans toute la France.
- **Taux de chômage** : 18,1 % dans les zones défavorisées contre 7,3 % dans toute la France.
- **Pourcentage de jeunes de 16-25 ans non scolarisés et sans emploi** : 25,2 % dans les zones défavorisées contre 12,9 % dans toute la France.
- **Revenu mensuel médian** : 1 168 € dans les zones défavorisées contre 1 822 € dans toute la France.
- **Taux de pauvreté** : 43,3 % dans les zones défavorisées contre 15,5 % dans toute la France.
- **Pourcentage de ménages vivant dans des logements surpeuplés** : 22,0 % dans les zones défavorisées contre 8,7 % dans toute la France.

Le graphique utilise des barres rouges pour les zones défavorisées et des barres bleues pour la France dans son ensemble, offrant une comparaison visuelle claire des disparités socio-économiques.

```