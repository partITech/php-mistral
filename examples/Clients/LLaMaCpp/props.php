<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\LlamaCpp\LlamaCppClient;

// docker run -p 8080:8080 -v ./models:/models ghcr.io/ggml-org/llama.cpp:server -m /models/llama-3.2-3b-instruct-q8_0.gguf -c 512 --host 0.0.0.0 --port 8080  --props
$llamacppUrl = getenv('LLAMACPP_URL');
$llamacppApiKey = getenv('LLAMACPP_API_KEY');

$client = new LlamaCppClient(apiKey: $llamacppApiKey, url: $llamacppUrl);

try {
    $response = $client->props();
    print_r($response);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}




//Array
//(
//    [default_generation_settings] => Array
//    (
//        [id] => 0
//            [id_task] => -1
//            [n_ctx] => 512
//            [speculative] =>
//            [is_processing] =>
//            [non_causal] =>
//            [params] => Array
//(
//    [n_predict] => -1
//                    [seed] => 4294967295
//                    [temperature] => 0.80000001192093
//                    [dynatemp_range] => 0
//                    [dynatemp_exponent] => 1
//                    [top_k] => 40
//                    [top_p] => 0.94999998807907
//                    [min_p] => 0.050000000745058
//                    [xtc_probability] => 0
//                    [xtc_threshold] => 0.10000000149012
//                    [typical_p] => 1
//                    [repeat_last_n] => 64
//                    [repeat_penalty] => 1
//                    [presence_penalty] => 0
//                    [frequency_penalty] => 0
//                    [dry_multiplier] => 0
//                    [dry_base] => 1.75
//                    [dry_allowed_length] => 2
//                    [dry_penalty_last_n] => 512
//                    [dry_sequence_breakers] => Array
//(
//    [0] =>
//
//        [1] => :
//                            [2] => "
//                            [3] => *
//                        )
//
//                    [mirostat] => 0
//                    [mirostat_tau] => 5
//                    [mirostat_eta] => 0.10000000149012
//                    [stop] => Array
//                        (
//                        )
//
//                    [max_tokens] => -1
//                    [n_keep] => 0
//                    [n_discard] => 0
//                    [ignore_eos] =>
//                    [stream] => 1
//                    [logit_bias] => Array
//                        (
//                        )
//
//                    [n_probs] => 0
//                    [min_keep] => 0
//                    [grammar] =>
//                    [grammar_lazy] =>
//                    [grammar_triggers] => Array
//                        (
//                        )
//
//                    [preserved_tokens] => Array
//                        (
//                        )
//
//                    [chat_format] => Content-only
//                    [samplers] => Array
//                        (
//                            [0] => penalties
//                            [1] => dry
//                            [2] => top_k
//                            [3] => typ_p
//                            [4] => top_p
//                            [5] => min_p
//                            [6] => xtc
//                            [7] => temperature
//                        )
//
//                    [speculative.n_max] => 16
//                    [speculative.n_min] => 0
//                    [speculative.p_min] => 0.75
//                    [timings_per_token] =>
//                    [post_sampling_probs] =>
//                    [lora] => Array
//                        (
//                        )
//
//                )
//
//            [prompt] =>
//            [next_token] => Array
//                (
//                    [has_next_token] => 1
//                    [has_new_line] =>
//                    [n_remain] => -1
//                    [n_decoded] => 0
//                    [stopping_word] =>
//                )
//
//        )
//
//    [total_slots] => 1
//    [model_path] => /models/llama-3.2-3b-instruct-q8_0.gguf
//    [chat_template] => {% set loop_messages = messages %}{% for message in loop_messages %}{% set content = '<|start_header_id|>' + message['role'] + '<|end_header_id|>
//
//'+ message['content'] | trim + '<|eot_id|>' %}{% if loop.index0 == 0 %}{% set content = bos_token + content %}{% endif %}{{ content }}{% endfor %}{{ '<|start_header_id|>assistant<|end_header_id|>
//
//' }}
//    [bos_token] => <|begin_of_text|>
//    [eos_token] => <|eot_id|>
//    [build_info] => b5002-2c3f8b85
//)
