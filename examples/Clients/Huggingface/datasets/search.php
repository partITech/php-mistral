<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceClient;
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);


try {
    $searchResult = $client->search(dataset: 'cornell-movie-review-data/rotten_tomatoes', split: 'train', config: 'default', query: 'love');
} catch (MistralClientException $e) {
    print_r($e);
}

print_r($searchResult);

/*
Array
(
    [features] => Array
        (
            [0] => Array
                (
                    [feature_idx] => 0
                    [name] => text
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [1] => Array
                (
                    [feature_idx] => 1
                    [name] => label
                    [type] => Array
                        (
                            [names] => Array
                                (
                                    [0] => neg
                                    [1] => pos
                                )

                            [_type] => ClassLabel
                        )

                )

        )

    [rows] => Array
        (
            [0] => Array
                (
                    [row_idx] => 6248
                    [row] => Array
                        (
                            [text] => who needs love like this ?
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [1] => Array
                (
                    [row_idx] => 1015
                    [row] => Array
                        (
                            [text] => if you love motown music , you'll love this documentary .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [2] => Array
                (
                    [row_idx] => 1042
                    [row] => Array
                        (
                            [text] => it's a lovely film with lovely performances by buy and accorsi .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [3] => Array
                (
                    [row_idx] => 2596
                    [row] => Array
                        (
                            [text] => a movie i loved on first sight and , even more important , love in remembrance .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [4] => Array
                (
                    [row_idx] => 359
                    [row] => Array
                        (
                            [text] => if you love reading and/or poetry , then by all means check it out . you'll probably love it .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [5] => Array
                (
                    [row_idx] => 3175
                    [row] => Array
                        (
                            [text] => i loved the look of this film .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [6] => Array
                (
                    [row_idx] => 1412
                    [row] => Array
                        (
                            [text] => i just loved every minute of this film .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [7] => Array
                (
                    [row_idx] => 5601
                    [row] => Array
                        (
                            [text] => you can see where big bad love is trying to go , but it never quite gets there .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [8] => Array
                (
                    [row_idx] => 2108
                    [row] => Array
                        (
                            [text] => stanley kwan has directed not only one of the best gay love stories ever made , but one of the best love stories of any stripe .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [9] => Array
                (
                    [row_idx] => 4224
                    [row] => Array
                        (
                            [text] => lovely and amazing is holofcener's deep , uncompromising curtsy to women she knows , and very likely is . when all is said and done , she loves them to pieces -- and so , i trust , will you .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [10] => Array
                (
                    [row_idx] => 985
                    [row] => Array
                        (
                            [text] => a potent allegorical love story .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [11] => Array
                (
                    [row_idx] => 1030
                    [row] => Array
                        (
                            [text] => everything you loved about it in 1982 is still there , for everybody who wants to be a kid again , or show it to their own kids .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [12] => Array
                (
                    [row_idx] => 1039
                    [row] => Array
                        (
                            [text] => a loving little film of considerable appeal .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [13] => Array
                (
                    [row_idx] => 1351
                    [row] => Array
                        (
                            [text] => aside from minor tinkering , this is the same movie you probably loved in 1994 , except that it looks even better .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [14] => Array
                (
                    [row_idx] => 1598
                    [row] => Array
                        (
                            [text] => if you're a fan of the series you'll love it and probably want to see it twice . i will be .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [15] => Array
                (
                    [row_idx] => 2243
                    [row] => Array
                        (
                            [text] => a gift to anyone who loves both dance and cinema
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [16] => Array
                (
                    [row_idx] => 3769
                    [row] => Array
                        (
                            [text] => a lovely film for the holiday season .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [17] => Array
                (
                    [row_idx] => 4855
                    [row] => Array
                        (
                            [text] => i like it . no , i hate it . no , i love it . . . hell , i dunno .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [18] => Array
                (
                    [row_idx] => 6652
                    [row] => Array
                        (
                            [text] => enduring love but exhausting cinema .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [19] => Array
                (
                    [row_idx] => 7438
                    [row] => Array
                        (
                            [text] => just entertaining enough not to hate , too mediocre to love .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [20] => Array
                (
                    [row_idx] => 7653
                    [row] => Array
                        (
                            [text] => i don't think this movie loves women at all .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [21] => Array
                (
                    [row_idx] => 75
                    [row] => Array
                        (
                            [text] => the appearance of treebeard and gollum's expanded role will either have you loving what you're seeing , or rolling your eyes . i loved it ! gollum's 'performance' is incredible !
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [22] => Array
                (
                    [row_idx] => 3121
                    [row] => Array
                        (
                            [text] => the story is a rather simplistic one : grief drives her , love drives him , and a second chance to find love in the most unlikely place - it struck a chord in me .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [23] => Array
                (
                    [row_idx] => 258
                    [row] => Array
                        (
                            [text] => a well-made and often lovely depiction of the mysteries of friendship .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [24] => Array
                (
                    [row_idx] => 957
                    [row] => Array
                        (
                            [text] => genuinely touching because it's realistic about all kinds of love .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [25] => Array
                (
                    [row_idx] => 2401
                    [row] => Array
                        (
                            [text] => throwing it all away for the fleeting joys of love's brief moment .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [26] => Array
                (
                    [row_idx] => 3429
                    [row] => Array
                        (
                            [text] => brave and sweetly rendered love story .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [27] => Array
                (
                    [row_idx] => 3517
                    [row] => Array
                        (
                            [text] => the bard as black comedy -- willie would have loved it .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [28] => Array
                (
                    [row_idx] => 3558
                    [row] => Array
                        (
                            [text] => . . . the kind of entertainment that parents love to have their kids see .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [29] => Array
                (
                    [row_idx] => 4516
                    [row] => Array
                        (
                            [text] => all in all , road to perdition is more in love with strangeness than excellence .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [30] => Array
                (
                    [row_idx] => 5402
                    [row] => Array
                        (
                            [text] => love may have been in the air onscreen , but i certainly wasn't feeling any of it .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [31] => Array
                (
                    [row_idx] => 6272
                    [row] => Array
                        (
                            [text] => prurient playthings aside , there's little to love about this english trifle .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [32] => Array
                (
                    [row_idx] => 7093
                    [row] => Array
                        (
                            [text] => i loved looking at this movie . i just didn't care as much for the story .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [33] => Array
                (
                    [row_idx] => 4226
                    [row] => Array
                        (
                            [text] => [fiji diver rusi vulakoro and the married couple howard and michelle hall] show us the world they love and make us love it , too .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [34] => Array
                (
                    [row_idx] => 2053
                    [row] => Array
                        (
                            [text] => warm in its loving yet unforgivingly inconsistent depiction of everyday people , relaxed in its perfect quiet pace and proud in its message . i loved this film .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [35] => Array
                (
                    [row_idx] => 114
                    [row] => Array
                        (
                            [text] => hip-hop has a history , and it's a metaphor for this love story .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [36] => Array
                (
                    [row_idx] => 524
                    [row] => Array
                        (
                            [text] => vividly conveys both the pitfalls and the pleasures of over-the-top love .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [37] => Array
                (
                    [row_idx] => 609
                    [row] => Array
                        (
                            [text] => in the end , punch-drunk love is one of those films that i wanted to like much more than i actually did . sometimes , that's enough .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [38] => Array
                (
                    [row_idx] => 770
                    [row] => Array
                        (
                            [text] => as hugh grant says repeatedly throughout the movie , 'lovely ! brilliant ! '
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [39] => Array
                (
                    [row_idx] => 1099
                    [row] => Array
                        (
                            [text] => a swashbuckling tale of love , betrayal , revenge and above all , faith .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [40] => Array
                (
                    [row_idx] => 1288
                    [row] => Array
                        (
                            [text] => is this love or is it masochism ? binoche makes it interesting trying to find out .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [41] => Array
                (
                    [row_idx] => 1804
                    [row] => Array
                        (
                            [text] => [a] wonderfully loopy tale of love , longing , and voting .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [42] => Array
                (
                    [row_idx] => 2008
                    [row] => Array
                        (
                            [text] => a winning piece of work filled with love for the movies of the 1960s .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [43] => Array
                (
                    [row_idx] => 2042
                    [row] => Array
                        (
                            [text] => a buoyant romantic comedy about friendship , love , and the truth that we're all in this together .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [44] => Array
                (
                    [row_idx] => 2304
                    [row] => Array
                        (
                            [text] => . . . plenty of warmth to go around , with music and laughter and the love of family .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [45] => Array
                (
                    [row_idx] => 2616
                    [row] => Array
                        (
                            [text] => i don't think most of the people who loved the 1989 paradiso will prefer this new version . but i do .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [46] => Array
                (
                    [row_idx] => 2805
                    [row] => Array
                        (
                            [text] => triumph of love is a very silly movie , but the silliness has a pedigree .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [47] => Array
                (
                    [row_idx] => 3012
                    [row] => Array
                        (
                            [text] => the most wondrous love story in years , it is a great film .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [48] => Array
                (
                    [row_idx] => 4082
                    [row] => Array
                        (
                            [text] => there's nothing like love to give a movie a b-12 shot , and cq shimmers with it .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [49] => Array
                (
                    [row_idx] => 4141
                    [row] => Array
                        (
                            [text] => interesting both as a historical study and as a tragic love story .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [50] => Array
                (
                    [row_idx] => 5248
                    [row] => Array
                        (
                            [text] => less a study in madness or love than a study in schoolgirl obsession .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [51] => Array
                (
                    [row_idx] => 5644
                    [row] => Array
                        (
                            [text] => 'lovely and amazing , ' unhappily , is neither . . . excessively strained and contrived .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [52] => Array
                (
                    [row_idx] => 6775
                    [row] => Array
                        (
                            [text] => this movie is about lying , cheating , but loving the friends you betray .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [53] => Array
                (
                    [row_idx] => 6867
                    [row] => Array
                        (
                            [text] => the parts are better than the whole ( bizarre , funny , tragic - like love in new york ) .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [54] => Array
                (
                    [row_idx] => 7198
                    [row] => Array
                        (
                            [text] => 'how many more voyages can this limping but dearly-loved franchise survive ? '
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [55] => Array
                (
                    [row_idx] => 7396
                    [row] => Array
                        (
                            [text] => the balkans provide the obstacle course for the love of a good woman .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [56] => Array
                (
                    [row_idx] => 7795
                    [row] => Array
                        (
                            [text] => lisa rinzler's cinematography may be lovely , but love liza's tale itself virtually collapses into an inhalant blackout , maintaining consciousness just long enough to achieve callow pretension .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [57] => Array
                (
                    [row_idx] => 27
                    [row] => Array
                        (
                            [text] => an idealistic love story that brings out the latent 15-year-old romantic in everyone .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [58] => Array
                (
                    [row_idx] => 195
                    [row] => Array
                        (
                            [text] => whether you're moved and love it , or bored or frustrated by the film , you'll still feel something .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [59] => Array
                (
                    [row_idx] => 531
                    [row] => Array
                        (
                            [text] => i love the way that it took chances and really asks you to take these great leaps of faith and pays off .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [60] => Array
                (
                    [row_idx] => 1149
                    [row] => Array
                        (
                            [text] => what better message than 'love thyself' could young women of any size receive ?
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [61] => Array
                (
                    [row_idx] => 1584
                    [row] => Array
                        (
                            [text] => the production has been made with an enormous amount of affection , so we believe these characters love each other .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [62] => Array
                (
                    [row_idx] => 2255
                    [row] => Array
                        (
                            [text] => it's a lovely , eerie film that casts an odd , rapt spell .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [63] => Array
                (
                    [row_idx] => 2572
                    [row] => Array
                        (
                            [text] => a low-key labor of love that strikes a very resonant chord .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [64] => Array
                (
                    [row_idx] => 2660
                    [row] => Array
                        (
                            [text] => kids will love its fantasy and adventure , and grownups should appreciate its whimsical humor .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [65] => Array
                (
                    [row_idx] => 2929
                    [row] => Array
                        (
                            [text] => a beautifully tooled action thriller about love and terrorism in korea .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [66] => Array
                (
                    [row_idx] => 3135
                    [row] => Array
                        (
                            [text] => the universal theme of becoming a better person through love has never been filmed more irresistibly than in 'baran . '
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [67] => Array
                (
                    [row_idx] => 3294
                    [row] => Array
                        (
                            [text] => this is so de palma . if you love him , you'll like it . if you don't . . . well , skip to another review .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [68] => Array
                (
                    [row_idx] => 3318
                    [row] => Array
                        (
                            [text] => if you love the music , and i do , its hard to imagine having more fun watching a documentary . . .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [69] => Array
                (
                    [row_idx] => 3604
                    [row] => Array
                        (
                            [text] => features one of the most affecting depictions of a love affair ever committed to film .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [70] => Array
                (
                    [row_idx] => 3858
                    [row] => Array
                        (
                            [text] => elegant and eloquent [meditation] on death and that most elusive of passions , love .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [71] => Array
                (
                    [row_idx] => 4447
                    [row] => Array
                        (
                            [text] => though the film is well-intentioned , one could rent the original and get the same love story and parable .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [72] => Array
                (
                    [row_idx] => 5106
                    [row] => Array
                        (
                            [text] => love liza is a festival film that would have been better off staying on the festival circuit .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [73] => Array
                (
                    [row_idx] => 5783
                    [row] => Array
                        (
                            [text] => christina ricci comedy about sympathy , hypocrisy and love is a misfire .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [74] => Array
                (
                    [row_idx] => 6776
                    [row] => Array
                        (
                            [text] => it smacks of purely commercial motivation , with no great love for the original .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [75] => Array
                (
                    [row_idx] => 7205
                    [row] => Array
                        (
                            [text] => an eccentric little comic/thriller deeply in love with its own quirky personality .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [76] => Array
                (
                    [row_idx] => 7678
                    [row] => Array
                        (
                            [text] => imagine susan sontag falling in love with howard stern .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [77] => Array
                (
                    [row_idx] => 785
                    [row] => Array
                        (
                            [text] => a provocative movie about loss , anger , greed , jealousy , sickness and love .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [78] => Array
                (
                    [row_idx] => 1378
                    [row] => Array
                        (
                            [text] => the movie is for fans who can't stop loving anime , and the fanatical excess built into it .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [79] => Array
                (
                    [row_idx] => 1404
                    [row] => Array
                        (
                            [text] => lovely and poignant . puts a human face on a land most westerners are unfamiliar with .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [80] => Array
                (
                    [row_idx] => 1467
                    [row] => Array
                        (
                            [text] => the draw [for " big bad love " ] is a solid performance by arliss howard .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [81] => Array
                (
                    [row_idx] => 1781
                    [row] => Array
                        (
                            [text] => with or without the sex , a wonderful tale of love and destiny , told well by a master storyteller
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [82] => Array
                (
                    [row_idx] => 1958
                    [row] => Array
                        (
                            [text] => a moving tale of love and destruction in unexpected places , unexamined lives .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [83] => Array
                (
                    [row_idx] => 2707
                    [row] => Array
                        (
                            [text] => overall , it's a very entertaining , thought-provoking film with a simple message : god is love .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [84] => Array
                (
                    [row_idx] => 3078
                    [row] => Array
                        (
                            [text] => it's a lovely , sad dance highlighted by kwan's unique directing style .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [85] => Array
                (
                    [row_idx] => 3878
                    [row] => Array
                        (
                            [text] => be patient with the lovely hush ! and your reward will be a thoughtful , emotional movie experience .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [86] => Array
                (
                    [row_idx] => 4150
                    [row] => Array
                        (
                            [text] => this charming , thought-provoking new york fest of life and love has its rewards .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [87] => Array
                (
                    [row_idx] => 4221
                    [row] => Array
                        (
                            [text] => a fanciful drama about napoleon's last years and his surprising discovery of love and humility .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [88] => Array
                (
                    [row_idx] => 4619
                    [row] => Array
                        (
                            [text] => everybody loves a david and goliath story , and this one is told almost entirely from david's point of view .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [89] => Array
                (
                    [row_idx] => 4624
                    [row] => Array
                        (
                            [text] => cedar somewhat defuses this provocative theme by submerging it in a hoary love triangle .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [90] => Array
                (
                    [row_idx] => 5162
                    [row] => Array
                        (
                            [text] => a bold ( and lovely ) experiment that will almost certainly bore most audiences into their own brightly colored dreams .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [91] => Array
                (
                    [row_idx] => 5451
                    [row] => Array
                        (
                            [text] => both the crime story and the love story are unusual . but they don't fit well together and neither is well told .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [92] => Array
                (
                    [row_idx] => 6071
                    [row] => Array
                        (
                            [text] => outer-space buffs might love this film , but others will find its pleasures intermittent .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [93] => Array
                (
                    [row_idx] => 6654
                    [row] => Array
                        (
                            [text] => a ponderous meditation on love that feels significantly longer than its relatively scant 97 minutes .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [94] => Array
                (
                    [row_idx] => 7451
                    [row] => Array
                        (
                            [text] => this story of unrequited love doesn't sustain interest beyond the first half-hour .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [95] => Array
                (
                    [row_idx] => 7767
                    [row] => Array
                        (
                            [text] => like an afterschool special with costumes by gianni versace , mad love looks better than it feels .
                            [label] => 0
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [96] => Array
                (
                    [row_idx] => 719
                    [row] => Array
                        (
                            [text] => the film is an enjoyable family film -- pretty much aimed at any youngster who loves horses .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [97] => Array
                (
                    [row_idx] => 801
                    [row] => Array
                        (
                            [text] => a map of the inner rhythms of love and jealousy and sacrifice drawn with a master's steady stroke .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [98] => Array
                (
                    [row_idx] => 806
                    [row] => Array
                        (
                            [text] => at times funny and at other times candidly revealing , it's an intriguing look at two performers who put themselves out there because they love what they do .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [99] => Array
                (
                    [row_idx] => 1418
                    [row] => Array
                        (
                            [text] => a tender , witty , captivating film about friendship , love , memory , trust and loyalty .
                            [label] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

        )

    [num_rows_total] => 234
    [num_rows_per_page] => 100
    [partial] =>
)

*/