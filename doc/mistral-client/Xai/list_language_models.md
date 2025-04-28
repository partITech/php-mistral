## List language models

List all chat and image understanding models available to the authenticating API key with full information. Additional information compared to /v1/models includes modalities, pricing, fingerprint and alias(es).
### Code
```php
use Partitech\PhpMistral\Clients\XAi\XAiClient;

$apiKey = getenv('GROK_API_KEY');

$client = new XAiClient(apiKey: (string) $apiKey);

try {
    $result = $client->listLanguageModels();
    print_r($result);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
```

### Result

```text
Array
(
    [models] => Array
        (
            [0] => Array
                (
                    [id] => grok-2-1212
                    [fingerprint] => fp_3c8052f993
                    [created] => 1737331200
                    [object] => model
                    [owned_by] => xai
                    [version] => 1.0
                    [input_modalities] => Array
                        (
                            [0] => text
                        )

                    [output_modalities] => Array
                        (
                            [0] => text
                        )

                    [prompt_text_token_price] => 20000
                    [cached_prompt_text_token_price] => 0
                    [prompt_image_token_price] => 0
                    [completion_text_token_price] => 100000
                    [aliases] => Array
                        (
                            [0] => grok-2
                            [1] => grok-2-latest
                        )

                )

            [1] => Array
                (
                    [id] => grok-2-vision-1212
                    [fingerprint] => fp_3858f1c03e
                    [created] => 1733961600
                    [object] => model
                    [owned_by] => xai
                    [version] => 1.0
                    [input_modalities] => Array
                        (
                            [0] => text
                            [1] => image
                        )

                    [output_modalities] => Array
                        (
                            [0] => text
                        )

                    [prompt_text_token_price] => 20000
                    [cached_prompt_text_token_price] => 0
                    [prompt_image_token_price] => 20000
                    [completion_text_token_price] => 100000
                    [aliases] => Array
                        (
                            [0] => grok-2-vision
                            [1] => grok-2-vision-latest
                        )

                )

            [2] => Array
                (
                    [id] => grok-3-beta
                    [fingerprint] => fp_688090ffbb
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                    [version] => 1.0
                    [input_modalities] => Array
                        (
                            [0] => text
                        )

                    [output_modalities] => Array
                        (
                            [0] => text
                        )

                    [prompt_text_token_price] => 30000
                    [cached_prompt_text_token_price] => 10000
                    [prompt_image_token_price] => 0
                    [completion_text_token_price] => 150000
                    [aliases] => Array
                        (
                            [0] => grok-3
                            [1] => grok-3-latest
                        )

                )

            [3] => Array
                (
                    [id] => grok-3-fast-beta
                    [fingerprint] => fp_482fcf675a
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                    [version] => 1.0
                    [input_modalities] => Array
                        (
                            [0] => text
                        )

                    [output_modalities] => Array
                        (
                            [0] => text
                        )

                    [prompt_text_token_price] => 50000
                    [cached_prompt_text_token_price] => 10000
                    [prompt_image_token_price] => 0
                    [completion_text_token_price] => 250000
                    [aliases] => Array
                        (
                            [0] => grok-3-fast
                            [1] => grok-3-fast-latest
                        )

                )

            [4] => Array
                (
                    [id] => grok-3-mini-beta
                    [fingerprint] => fp_d133ae3397
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                    [version] => 1.0
                    [input_modalities] => Array
                        (
                            [0] => text
                        )

                    [output_modalities] => Array
                        (
                            [0] => text
                        )

                    [prompt_text_token_price] => 3000
                    [cached_prompt_text_token_price] => 1800
                    [prompt_image_token_price] => 0
                    [completion_text_token_price] => 5000
                    [aliases] => Array
                        (
                            [0] => grok-3-mini
                            [1] => grok-3-mini-latest
                        )

                )

            [5] => Array
                (
                    [id] => grok-3-mini-fast-beta
                    [fingerprint] => fp_aff44fdaaf
                    [created] => 1743724800
                    [object] => model
                    [owned_by] => xai
                    [version] => 1.0
                    [input_modalities] => Array
                        (
                            [0] => text
                        )

                    [output_modalities] => Array
                        (
                            [0] => text
                        )

                    [prompt_text_token_price] => 6000
                    [cached_prompt_text_token_price] => 1800
                    [prompt_image_token_price] => 0
                    [completion_text_token_price] => 40000
                    [aliases] => Array
                        (
                            [0] => grok-3-mini-fast
                            [1] => grok-3-mini-fast-latest
                        )

                )

            [6] => Array
                (
                    [id] => grok-beta
                    [fingerprint] => fp_7ce9497c81
                    [created] => 1727136000
                    [object] => model
                    [owned_by] => xai
                    [version] => 1.0
                    [input_modalities] => Array
                        (
                            [0] => text
                        )

                    [output_modalities] => Array
                        (
                            [0] => text
                        )

                    [prompt_text_token_price] => 50000
                    [cached_prompt_text_token_price] => 0
                    [prompt_image_token_price] => 0
                    [completion_text_token_price] => 150000
                    [aliases] => Array
                        (
                        )

                )

            [7] => Array
                (
                    [id] => grok-vision-beta
                    [fingerprint] => fp_be5fe2ebbd
                    [created] => 1730764800
                    [object] => model
                    [owned_by] => xai
                    [version] => 1.0
                    [input_modalities] => Array
                        (
                            [0] => text
                            [1] => image
                        )

                    [output_modalities] => Array
                        (
                            [0] => text
                        )

                    [prompt_text_token_price] => 50000
                    [cached_prompt_text_token_price] => 0
                    [prompt_image_token_price] => 50000
                    [completion_text_token_price] => 150000
                    [aliases] => Array
                        (
                        )

                )

        )

)
```
