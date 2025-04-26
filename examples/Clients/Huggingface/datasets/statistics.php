<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $searchResult = $client->statistics(
        dataset: 'cornell-movie-review-data/rotten_tomatoes',
        split: 'train',
        config: 'default'
    );
    print_r($searchResult);
} catch (MistralClientException $e) {
    print_r($e);
}

/*
Array
(
    [num_examples] => 8530
    [statistics] => Array
        (
            [0] => Array
                (
                    [column_name] => label
                    [column_type] => class_label
                    [column_statistics] => Array
                        (
                            [nan_count] => 0
                            [nan_proportion] => 0
                            [no_label_count] => 0
                            [no_label_proportion] => 0
                            [n_unique] => 2
                            [frequencies] => Array
                                (
                                    [neg] => 4265
                                    [pos] => 4265
                                )

                        )

                )

            [1] => Array
                (
                    [column_name] => text
                    [column_type] => string_text
                    [column_statistics] => Array
                        (
                            [nan_count] => 0
                            [nan_proportion] => 0
                            [min] => 4
                            [max] => 267
                            [mean] => 113.97163
                            [median] => 111
                            [std] => 51.05223
                            [histogram] => Array
                                (
                                    [hist] => Array
                                        (
                                            [0] => 302
                                            [1] => 955
                                            [2] => 1358
                                            [3] => 1701
                                            [4] => 1574
                                            [5] => 1215
                                            [6] => 804
                                            [7] => 385
                                            [8] => 176
                                            [9] => 60
                                        )

                                    [bin_edges] => Array
                                        (
                                            [0] => 4
                                            [1] => 31
                                            [2] => 58
                                            [3] => 85
                                            [4] => 112
                                            [5] => 139
                                            [6] => 166
                                            [7] => 193
                                            [8] => 220
                                            [9] => 247
                                            [10] => 267
                                        )

                                )

                        )

                )

        )

    [partial] =>
)

*/