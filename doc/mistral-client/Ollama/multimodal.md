## Multimodal

### Code
```php
use Partitech\PhpMistral\Clients\Ollama\OllamaClient;
use Partitech\PhpMistral\Message;

$ollamaUrl = getenv('OLLAMA_URL');
$client = new OllamaClient(url: $ollamaUrl);

$message = $client->newMessage();
$message->setRole('user');
$message->addContent(type: Message::MESSAGE_TYPE_TEXT, content: 'Proceed step by step. For each media, describe it carefully.');
$message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: $client->downloadToTmp('https://s3.amazonaws.com/cms.ipressroom.com/338/files/201808/5b894ee1a138352221103195_A680%7Ejogging-edit/A680%7Ejogging-edit_hero.jpg'));
$message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: $client->downloadToTmp('https://www.wolframcloud.com/obj/resourcesystem/images/a0e/a0ee3983-46c6-4c92-b85d-059044639928/6af8cfb971db031b.png'));
$message->addContent(type: Message::MESSAGE_TYPE_BASE64, content: realpath('./../../medias/pixtral_image_example_charts.jpeg'));
$messages = $client->getMessages()->addMessage($message);

try {
    $result = $client->chat(
        $messages,
        [
            'model' => 'gemma3:12b',
            'max_tokens' => 1024,
        ]
    );
    print($result->getMessage());
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

### Result

```text
Okay, let's break down each media step-by-step.

**Media 1: Three People Running in a Park**

**Description:** This is a color photograph depicting three individuals jogging along a dirt path in a lush, green park. The perspective is level with the runners, giving the viewer a sense of participating in the activity.
*   **People:**
    *   A man on the left, appears to be in his late 30s to early 40s, with short, dark hair and a well-built physique. He is wearing a grey, long-sleeved athletic shirt and black shorts. He is smiling and his posture suggests he's comfortable with the run.
    *   A young woman in the middle likely is in her late teens or early 20s, is wearing a bright yellow athletic top and black running shorts. Her hair is loose and blowing in the breeze. She has a youthful, energetic expression and is smiling.
    *   A woman on the right, seems to be in her 30s or 40s, is wearing a pink long-sleeved shirt and black leggings. She is smiling and appears to be enjoying the run. She has her hair pulled back.
*   **Setting:** The background consists of dense green vegetation – trees and shrubs – creating a natural, park-like atmosphere. The light is bright, suggesting a sunny day. There's a clear path extending into the distance, suggesting a longer run is possible.
*   **Overall Feeling:** This image conveys a sense of health, fitness, camaraderie, and enjoyment of nature. It has a positive and uplifting vibe.

**Media 2: Family Portrait**

**Description:** This is a color photograph featuring a family of five posed on a white background.
*   **People:**
    *   Two women – likely a mother and a daughter - are present, wearing matching red long-sleeved shirts. The woman on the left has long, flowing brown hair and a warm smile. The woman on the right has blonde hair and a similar expression.
    *   Two young boys, presumably their sons or brothers, are positioned in between the two women. They also wear matching red long-sleeved shirts. Each boy has a joyful expression
    *   A man appears to be the father, sits in the center is looking directly at the camera, with a big smile. He is also wearing a matching red shirt.
*   **Background:** The background is a clean, white surface. This minimalistic background focuses the viewer's attention solely on the family members.
*   **Pose:** Everyone is laying with their forearms and hands resting on the ground, close together.
*   **Overall Feeling**: The image portrays a cohesive and happy family unit. It likely was taken as a formal portrait or for a special occasion.

**Media 3: Infographic - France's Social Divide**

**Description**: This is a color infographic presented by Statista that compares socioeconomic indicators between disadvantaged areas and the whole of France.

*   **Title**: "France's Social Divide"
*   **Overall Design**: The infographic utilizes a bar chart format to visually represent the comparison. Each bar shows the percentage or value of a specific indicator, with different colors representing disadvantaged areas (“Red”) and all of France ("Blue").
*   **Indicators Shown**: The infographic presents data for the following indicators:
    *   Percentage of working-class members
    *   Unemployment rate
    *   Percentage of 16-25 year olds not in school or employed
    *   Median monthly income (in Euros)
    *   Poverty rate
    *   Percentage of households in overcrowded housing.
*   **Annotation**: There’s a footnote clarifying the definition of “disadvantaged areas” and providing data sources and dates.
*   **Purpose:** The infographic is designed to clearly illustrate the disparities between disadvantaged areas and the rest of France, highlighting economic and social challenges.



If you would like, give me another media to describe!
```
