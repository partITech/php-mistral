#!/usr/bin/php
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Messages;
use Partitech\PhpMistral\MistralClient;



/*
 * Agent:
 *  - Instructions: You are a French-speaking virtual agent, designed to answer your questions in French only, no matter the language of the question
 *  - few shot prompt :
 *          -  question : What's the capital of France ?
 *          -  answer   : La capitale de la France est Paris.
 */

// export MISTRAL_API_KEY=your_api_key
$apiKey  = getenv('MISTRAL_API_KEY');
$agentId = getenv('MISTRAL_AGENT_ID');

$client = new MistralClient($apiKey);
$messages = new Messages();
$messages->addUserMessage('Write a poem about Paris');
try {
    $result = $client->agent(
        messages: $messages,
        agent: $agentId,
        params: [],
        stream: false
    );
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}

print_r($result->getMessage());
/*
Paris, ville de lumière,
De l'amour et de l'art,
Ses rues étroites et ses larges boulevards,
Sont un enchantement pour le cœur.

La Tour Eiffel, la Seine qui coule,
Le Louvre, le Musée d'Orsay,
Les cafés, les jardins, les ponts,
Paris, tu es magique !

De Montmartre à Montparnasse,
De Saint-Germain à Pigalle,
Chaque quartier a son charme,
Paris, tu es unique !

Ville de la mode et de la gastronomie,
De la liberté et de l'égalité,
Paris, tu es notre capitale,
Notre ville lumière, pour l'éternité.
*/
 echo PHP_EOL . "*****************" . PHP_EOL;

$client = new MistralClient($apiKey);
$messages = new Messages();
$messages->addUserMessage('Write a poem about Paris');
try {
    foreach ($client->agent(messages: $messages, agent: $agentId, params: [], stream: true) as $chunk) {
        echo $chunk->getChunk();
    }

} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}


/*
 Paris, ville de lumière,
De l'amour et de la vie,
Ses rues étroites et ses larges boulevards,
Rendent l'âme rêveuse et inspirée.

La Seine coule paisiblement,
Emportant avec elle les secrets de la ville,
Les ponts qui la traversent sont des œuvres d'art,
Chacun raconte une histoire à part.

La Tour Eiffel, symbole de la France,
Se dresse fièrement vers le ciel,
Elle est le témoin de l'amour et de l'amitié,
Qui unissent les cœurs de tous les visiteurs.

Le Louvre, le Musée d'Orsay,
Révèlent les trésors de l'histoire de l'art,
Les artistes de la rue créent des merveilles,
Paris est un véritable musée à ciel ouvert.

La ville ne dort jamais, elle est toujours en mouvement,
Ses nuits sont animées, ses jours sont pleins de vie,
Paris, ville de lumière, de l'amour et de la vie,
Est une source inépuisable d'inspiration et de bonheur.Paris, ville de lumière,
De l'amour et de l'histoire,
Ses rues animées, ses monuments fiers,
Rendent cette cité unique au monde.

La Tour Eiffel, la Seine qui coule,
Le Louvre, Notre-Dame, tant de merveilles,
Chaque coin de rue raconte une histoire,
Paris, tu es une ville de rêves.

De Montmartre à Pigalle, en passant par le Marais,
Chaque quartier a son charme et son caractère,
Ici, la vie est un festin pour les sens,
Paris, tu es une symphonie de couleurs et de saveurs.

Ville de l'art, de la mode et de la gastronomie,
Tu es un modèle d'élégance et de raffinement,
Paris, tu es une source d'inspiration,
Pour les artistes et les poètes du monde entier.

Même sous la pluie, tu restes magnifique,
Paris, tu es une ville de contrastes,
Mais toujours, tu restes la ville lumière,
La ville de l'amour et de l'histoire.
 */