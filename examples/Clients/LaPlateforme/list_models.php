<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\Mistral\MistralClient;

// export MISTRAL_API_KEY=your_api_key
$apiKey = getenv('MISTRAL_API_KEY');
$client = new MistralClient($apiKey);

try {
    $result = $client->listModels();
    print_r($result);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}




/*
Array
(
    [object] => list
    [data] => Array
        (
            [0] => Array
                (
                    [id] => ministral-3b-2410
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => ministral-3b-2410
                    [description] => Official ministral-3b-2410 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => ministral-3b-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [1] => Array
                (
                    [id] => ministral-3b-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => ministral-3b-2410
                    [description] => Official ministral-3b-2410 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => ministral-3b-2410
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [2] => Array
                (
                    [id] => ministral-8b-2410
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => ministral-8b-2410
                    [description] => Official ministral-8b-2410 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => ministral-8b-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [3] => Array
                (
                    [id] => ministral-8b-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => ministral-8b-2410
                    [description] => Official ministral-8b-2410 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => ministral-8b-2410
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [4] => Array
                (
                    [id] => open-mistral-7b
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mistral-7b
                    [description] => Official open-mistral-7b Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-tiny
                            [1] => mistral-tiny-2312
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [5] => Array
                (
                    [id] => mistral-tiny
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mistral-7b
                    [description] => Official open-mistral-7b Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => open-mistral-7b
                            [1] => mistral-tiny-2312
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [6] => Array
                (
                    [id] => mistral-tiny-2312
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mistral-7b
                    [description] => Official open-mistral-7b Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => open-mistral-7b
                            [1] => mistral-tiny
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [7] => Array
                (
                    [id] => open-mistral-nemo
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mistral-nemo
                    [description] => Official open-mistral-nemo Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => open-mistral-nemo-2407
                            [1] => mistral-tiny-2407
                            [2] => mistral-tiny-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [8] => Array
                (
                    [id] => open-mistral-nemo-2407
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mistral-nemo
                    [description] => Official open-mistral-nemo Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => open-mistral-nemo
                            [1] => mistral-tiny-2407
                            [2] => mistral-tiny-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [9] => Array
                (
                    [id] => mistral-tiny-2407
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mistral-nemo
                    [description] => Official open-mistral-nemo Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => open-mistral-nemo
                            [1] => open-mistral-nemo-2407
                            [2] => mistral-tiny-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [10] => Array
                (
                    [id] => mistral-tiny-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mistral-nemo
                    [description] => Official open-mistral-nemo Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => open-mistral-nemo
                            [1] => open-mistral-nemo-2407
                            [2] => mistral-tiny-2407
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [11] => Array
                (
                    [id] => open-mixtral-8x7b
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mixtral-8x7b
                    [description] => Official open-mixtral-8x7b Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-small
                            [1] => mistral-small-2312
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [12] => Array
                (
                    [id] => mistral-small
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mixtral-8x7b
                    [description] => Official open-mixtral-8x7b Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => open-mixtral-8x7b
                            [1] => mistral-small-2312
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [13] => Array
                (
                    [id] => mistral-small-2312
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mixtral-8x7b
                    [description] => Official open-mixtral-8x7b Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => open-mixtral-8x7b
                            [1] => mistral-small
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [14] => Array
                (
                    [id] => open-mixtral-8x22b
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mixtral-8x22b
                    [description] => Official open-mixtral-8x22b Mistral AI model
                    [max_context_length] => 65536
                    [aliases] => Array
                        (
                            [0] => open-mixtral-8x22b-2404
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [15] => Array
                (
                    [id] => open-mixtral-8x22b-2404
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => open-mixtral-8x22b
                    [description] => Official open-mixtral-8x22b Mistral AI model
                    [max_context_length] => 65536
                    [aliases] => Array
                        (
                            [0] => open-mixtral-8x22b
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [16] => Array
                (
                    [id] => mistral-small-2402
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-small-2402
                    [description] => Official mistral-small-2402 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [17] => Array
                (
                    [id] => mistral-small-2409
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-small-2409
                    [description] => Official mistral-small-2409 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [18] => Array
                (
                    [id] => mistral-medium-2312
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-medium-2312
                    [description] => Official mistral-medium-2312 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-medium
                            [1] => mistral-medium-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [19] => Array
                (
                    [id] => mistral-medium
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-medium-2312
                    [description] => Official mistral-medium-2312 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-medium-2312
                            [1] => mistral-medium-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [20] => Array
                (
                    [id] => mistral-medium-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-medium-2312
                    [description] => Official mistral-medium-2312 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-medium-2312
                            [1] => mistral-medium
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [21] => Array
                (
                    [id] => mistral-large-2402
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-large-2402
                    [description] => Official mistral-large-2402 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [22] => Array
                (
                    [id] => mistral-large-2407
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-large-2407
                    [description] => Official mistral-large-2407 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [23] => Array
                (
                    [id] => mistral-large-2411
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-large-2411
                    [description] => Official mistral-large-2411 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => mistral-large-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [24] => Array
                (
                    [id] => mistral-large-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-large-2411
                    [description] => Official mistral-large-2411 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => mistral-large-2411
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [25] => Array
                (
                    [id] => pixtral-large-2411
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] => 1
                            [classification] =>
                        )

                    [name] => pixtral-large-2411
                    [description] => Official pixtral-large-2411 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => pixtral-large-latest
                            [1] => mistral-large-pixtral-2411
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [26] => Array
                (
                    [id] => pixtral-large-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] => 1
                            [classification] =>
                        )

                    [name] => pixtral-large-2411
                    [description] => Official pixtral-large-2411 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => pixtral-large-2411
                            [1] => mistral-large-pixtral-2411
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [27] => Array
                (
                    [id] => mistral-large-pixtral-2411
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] => 1
                            [classification] =>
                        )

                    [name] => pixtral-large-2411
                    [description] => Official pixtral-large-2411 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => pixtral-large-2411
                            [1] => pixtral-large-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [28] => Array
                (
                    [id] => codestral-2405
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] => 1
                            [function_calling] => 1
                            [fine_tuning] => 1
                            [vision] =>
                            [classification] =>
                        )

                    [name] => codestral-2405
                    [description] => Official codestral-2405 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [29] => Array
                (
                    [id] => codestral-2501
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] => 1
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => codestral-2501
                    [description] => Official codestral-2501 Mistral AI model
                    [max_context_length] => 262144
                    [aliases] => Array
                        (
                            [0] => codestral-latest
                            [1] => codestral-2412
                            [2] => codestral-2411-rc5
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [30] => Array
                (
                    [id] => codestral-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] => 1
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => codestral-2501
                    [description] => Official codestral-2501 Mistral AI model
                    [max_context_length] => 262144
                    [aliases] => Array
                        (
                            [0] => codestral-2501
                            [1] => codestral-2412
                            [2] => codestral-2411-rc5
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [31] => Array
                (
                    [id] => codestral-2412
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] => 1
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => codestral-2501
                    [description] => Official codestral-2501 Mistral AI model
                    [max_context_length] => 262144
                    [aliases] => Array
                        (
                            [0] => codestral-2501
                            [1] => codestral-latest
                            [2] => codestral-2411-rc5
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [32] => Array
                (
                    [id] => codestral-2411-rc5
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] => 1
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => codestral-2501
                    [description] => Official codestral-2501 Mistral AI model
                    [max_context_length] => 262144
                    [aliases] => Array
                        (
                            [0] => codestral-2501
                            [1] => codestral-latest
                            [2] => codestral-2412
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [33] => Array
                (
                    [id] => codestral-mamba-2407
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => codestral-mamba-2407
                    [description] => Official codestral-mamba-2407 Mistral AI model
                    [max_context_length] => 262144
                    [aliases] => Array
                        (
                            [0] => open-codestral-mamba
                            [1] => codestral-mamba-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [34] => Array
                (
                    [id] => open-codestral-mamba
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => codestral-mamba-2407
                    [description] => Official codestral-mamba-2407 Mistral AI model
                    [max_context_length] => 262144
                    [aliases] => Array
                        (
                            [0] => codestral-mamba-2407
                            [1] => codestral-mamba-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [35] => Array
                (
                    [id] => codestral-mamba-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => codestral-mamba-2407
                    [description] => Official codestral-mamba-2407 Mistral AI model
                    [max_context_length] => 262144
                    [aliases] => Array
                        (
                            [0] => codestral-mamba-2407
                            [1] => open-codestral-mamba
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.7
                    [type] => base
                )

            [36] => Array
                (
                    [id] => pixtral-12b-2409
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] => 1
                            [classification] =>
                        )

                    [name] => pixtral-12b-2409
                    [description] => Official pixtral-12b-2409 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => pixtral-12b
                            [1] => pixtral-12b-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [37] => Array
                (
                    [id] => pixtral-12b
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] => 1
                            [classification] =>
                        )

                    [name] => pixtral-12b-2409
                    [description] => Official pixtral-12b-2409 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => pixtral-12b-2409
                            [1] => pixtral-12b-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [38] => Array
                (
                    [id] => pixtral-12b-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] => 1
                            [classification] =>
                        )

                    [name] => pixtral-12b-2409
                    [description] => Official pixtral-12b-2409 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => pixtral-12b-2409
                            [1] => pixtral-12b
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [39] => Array
                (
                    [id] => mistral-small-2501
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-small-2501
                    [description] => Official mistral-small-2501 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [40] => Array
                (
                    [id] => mistral-small-2503
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] => 1
                            [classification] =>
                        )

                    [name] => mistral-small-2503
                    [description] => Official mistral-small-2503 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => mistral-small-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [41] => Array
                (
                    [id] => mistral-small-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] => 1
                            [classification] =>
                        )

                    [name] => mistral-small-2503
                    [description] => Official mistral-small-2503 Mistral AI model
                    [max_context_length] => 131072
                    [aliases] => Array
                        (
                            [0] => mistral-small-2503
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [42] => Array
                (
                    [id] => mistral-saba-2502
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-saba-2502
                    [description] => Official mistral-saba-2502 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-saba-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [43] => Array
                (
                    [id] => mistral-saba-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] => 1
                            [completion_fim] =>
                            [function_calling] => 1
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-saba-2502
                    [description] => Official mistral-saba-2502 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-saba-2502
                        )

                    [deprecation] =>
                    [default_model_temperature] => 0.3
                    [type] => base
                )

            [44] => Array
                (
                    [id] => mistral-embed
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] =>
                            [completion_fim] =>
                            [function_calling] =>
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-embed
                    [description] => Official mistral-embed Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                        )

                    [deprecation] =>
                    [default_model_temperature] =>
                    [type] => base
                )

            [45] => Array
                (
                    [id] => mistral-moderation-2411
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] =>
                            [completion_fim] =>
                            [function_calling] =>
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-moderation-2411
                    [description] => Official mistral-moderation-2411 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-moderation-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] =>
                    [type] => base
                )

            [46] => Array
                (
                    [id] => mistral-moderation-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] =>
                            [completion_fim] =>
                            [function_calling] =>
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-moderation-2411
                    [description] => Official mistral-moderation-2411 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-moderation-2411
                        )

                    [deprecation] =>
                    [default_model_temperature] =>
                    [type] => base
                )

            [47] => Array
                (
                    [id] => mistral-ocr-2503
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] =>
                            [completion_fim] =>
                            [function_calling] =>
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-ocr-2503
                    [description] => Official mistral-ocr-2503 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-ocr-latest
                        )

                    [deprecation] =>
                    [default_model_temperature] =>
                    [type] => base
                )

            [48] => Array
                (
                    [id] => mistral-ocr-latest
                    [object] => model
                    [created] => 1745580570
                    [owned_by] => mistralai
                    [capabilities] => Array
                        (
                            [completion_chat] =>
                            [completion_fim] =>
                            [function_calling] =>
                            [fine_tuning] =>
                            [vision] =>
                            [classification] =>
                        )

                    [name] => mistral-ocr-2503
                    [description] => Official mistral-ocr-2503 Mistral AI model
                    [max_context_length] => 32768
                    [aliases] => Array
                        (
                            [0] => mistral-ocr-2503
                        )

                    [deprecation] =>
                    [default_model_temperature] =>
                    [type] => base
                )

        )

)
 */