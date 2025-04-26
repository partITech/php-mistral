## List by author

#### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');
$datasetUser = getenv('HF_USER');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $datasets = $client->listDatasets(
        author: $datasetUser,
        limit: 5,
        sort: 'lastModified',
        direction: -1,
        full: true
    );
    print_r($datasets);
} catch (MistralClientException $e) {
    print_r($e);
}

```


#### Result

```text
Array
(
    [0] => Array
        (
            [_id] => 68092ad75f76fe38296ebc97
            [id] => Bourdin/test3
            [author] => Bourdin
            [cardData] => Array
                (
                    [language] => Array
                        (
                            [0] => en
                        )

                    [license] => cc0-1.0
                    [paperswithcode_id] => civil-comments
                    [pretty_name] => Civil Comments
                    [tags] => Array
                        (
                            [0] => toxic-comment-classification
                        )

                    [task_categories] => Array
                        (
                            [0] => text-classification
                        )

                    [task_ids] => Array
                        (
                            [0] => multi-label-classification
                        )

                    [dataset_info] => Array
                        (
                            [features] => Array
                                (
                                    [0] => Array
                                        (
                                            [name] => text
                                            [dtype] => string
                                        )

                                    [1] => Array
                                        (
                                            [name] => toxicity
                                            [dtype] => float32
                                        )

                                    [2] => Array
                                        (
                                            [name] => severe_toxicity
                                            [dtype] => float32
                                        )

                                    [3] => Array
                                        (
                                            [name] => obscene
                                            [dtype] => float32
                                        )

                                    [4] => Array
                                        (
                                            [name] => threat
                                            [dtype] => float32
                                        )

                                    [5] => Array
                                        (
                                            [name] => insult
                                            [dtype] => float32
                                        )

                                    [6] => Array
                                        (
                                            [name] => identity_attack
                                            [dtype] => float32
                                        )

                                    [7] => Array
                                        (
                                            [name] => sexual_explicit
                                            [dtype] => float32
                                        )

                                )

                            [splits] => Array
                                (
                                    [0] => Array
                                        (
                                            [name] => train
                                            [num_bytes] => 594805164
                                            [num_examples] => 1804874
                                        )

                                    [1] => Array
                                        (
                                            [name] => validation
                                            [num_bytes] => 32216880
                                            [num_examples] => 97320
                                        )

                                    [2] => Array
                                        (
                                            [name] => test
                                            [num_bytes] => 31963524
                                            [num_examples] => 97320
                                        )

                                )

                            [download_size] => 422061071
                            [dataset_size] => 658985568
                        )

                    [configs] => Array
                        (
                            [0] => Array
                                (
                                    [config_name] => default
                                    [data_files] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [split] => train
                                                    [path] => data/train-*
                                                )

                                            [1] => Array
                                                (
                                                    [split] => validation
                                                    [path] => data/validation-*
                                                )

                                            [2] => Array
                                                (
                                                    [split] => test
                                                    [path] => data/test-*
                                                )

                                        )

                                )

                        )

                )

            [disabled] => 
            [gated] => 
            [lastModified] => 2025-04-24T15:16:05.000Z
            [likes] => 0
            [private] => 
            [sha] => ddccaf722ffd31715adf242647f2a940756f69a9
            [description] => 
	
		
		Dataset Card for "civil_comments"
	


	
		
		Dataset Summary
	

The comments in this dataset come from an archive of the Civil Comments
platform, a commenting plugin for independent news sites. These public comments
were created from 2015 - 2017 and appeared on approximately 50 English-language
news sites across the world. When Civil Comments shut down in 2017, they chose
to make the public comments available in a lasting open archive to enable future
research. The original data… See the full description on the dataset page: https://huggingface.co/datasets/Bourdin/test3.
            [downloads] => 43
            [paperswithcode_id] => civil-comments
            [tags] => Array
                (
                    [0] => task_categories:text-classification
                    [1] => task_ids:multi-label-classification
                    [2] => language:en
                    [3] => license:cc0-1.0
                    [4] => size_categories:1M<n<10M
                    [5] => format:parquet
                    [6] => modality:tabular
                    [7] => modality:text
                    [8] => library:datasets
                    [9] => library:dask
                    [10] => library:mlcroissant
                    [11] => library:polars
                    [12] => arxiv:1903.04561
                    [13] => region:us
                    [14] => toxic-comment-classification
                )

            [createdAt] => 2025-04-23T18:00:55.000Z
            [key] => 
        )

)

```