## Pull

### Without streaming
#### Code
```php
try {
    $info = $client->pull(
        model : 'llama3.2:1b',
        insecure : true
    );
    print_r($info);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
```

#### Result

```text
Array
(
    [0] => Array
        (
            [status] => pulling manifest
        )

    [1] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
        )

    [2] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
        )

    [3] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
        )

    [4] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
        )

    [5] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
        )

    [6] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
        )

    [7] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 2889643
        )

    [8] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 8167800
        )

    [9] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 14406923
        )

    [10] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 18189166
        )

    [11] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 23773294
        )

    [12] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 25924864
        )

    [13] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 29500672
        )

    [14] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 36726016
        )

    [15] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 45389056
        )

    [16] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 59143424
        )

    [17] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 66082048
        )

    [18] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 71677184
        )

    [19] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 85968128
        )

    [20] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 90289408
        )

    [21] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 97219840
        )

    [22] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 102356224
        )

    [23] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 108770560
        )

    [24] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 114889984
        )

    [25] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 124581120
        )

    [26] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 131183872
        )

    [27] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 138188032
        )

    [28] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 146347264
        )

    [29] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 152364288
        )

    [30] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 160806144
        )

    [31] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 168031488
        )

    [32] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 174318848
        )

    [33] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 182899968
        )

    [34] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 192111872
        )

    [35] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 199992576
        )

    [36] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 207270976
        )

    [37] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 214316096
        )

    [38] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 221385792
        )

    [39] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 228410432
        )

    [40] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 235471936
        )

    [41] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 242529344
        )

    [42] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 249549888
        )

    [43] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 255636544
        )

    [44] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 263640128
        )

    [45] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 267293760
        )

    [46] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 277705792
        )

    [47] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 280613952
        )

    [48] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 291648576
        )

    [49] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 298886208
        )

    [50] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 303678528
        )

    [51] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 312972352
        )

    [52] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 319956032
        )

    [53] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 326992960
        )

    [54] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 334058560
        )

    [55] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 341075008
        )

    [56] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 348124224
        )

    [57] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 355157056
        )

    [58] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 362185792
        )

    [59] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 369230912
        )

    [60] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 376312896
        )

    [61] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 383358016
        )

    [62] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 390390848
        )

    [63] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 397435968
        )

    [64] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 404522048
        )

    [65] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 411538496
        )

    [66] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 418591808
        )

    [67] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 425661504
        )

    [68] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 432690240
        )

    [69] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 439739456
        )

    [70] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 446772288
        )

    [71] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 453829696
        )

    [72] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 460883008
        )

    [73] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 467952704
        )

    [74] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 474969152
        )

    [75] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 482026560
        )

    [76] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 489116736
        )

    [77] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 496124992
        )

    [78] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 503178304
        )

    [79] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 508986432
        )

    [80] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 517301312
        )

    [81] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 523777088
        )

    [82] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 531387456
        )

    [83] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 538412096
        )

    [84] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 545477696
        )

    [85] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 552502336
        )

    [86] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 559543360
        )

    [87] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 566588480
        )

    [88] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 573617216
        )

    [89] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 580715584
        )

    [90] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 587760704
        )

    [91] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 594805824
        )

    [92] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 601859136
        )

    [93] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 608822336
        )

    [94] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 614958144
        )

    [95] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 622826560
        )

    [96] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 628900928
        )

    [97] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 636896320
        )

    [98] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 643941440
        )

    [99] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 650974272
        )

    [100] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 658060352
        )

    [101] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 665125952
        )

    [102] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 672154688
        )

    [103] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 676799552
        )

    [104] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 685478976
        )

    [105] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 689747008
        )

    [106] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 699905088
        )

    [107] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 706221120
        )

    [108] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 711754816
        )

    [109] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 721171520
        )

    [110] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 728208448
        )

    [111] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 735294528
        )

    [112] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 742347840
        )

    [113] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 749364288
        )

    [114] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 756454464
        )

    [115] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 763462720
        )

    [116] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 770528320
        )

    [117] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 777598016
        )

    [118] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 784622656
        )

    [119] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 791680064
        )

    [120] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 798745664
        )

    [121] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 805778496
        )

    [122] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 812807232
        )

    [123] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 815903808
        )

    [124] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 824054848
        )

    [125] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 833836096
        )

    [126] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 836621376
        )

    [127] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 844862528
        )

    [128] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 854647872
        )

    [129] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 859878464
        )

    [130] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 868770880
        )

    [131] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 875881536
        )

    [132] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 882861120
        )

    [133] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 889947200
        )

    [134] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 896971840
        )

    [135] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 900654144
        )

    [136] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 911078464
        )

    [137] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 918123584
        )

    [138] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 921834560
        )

    [139] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 930333760
        )

    [140] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 939312192
        )

    [141] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 942535744
        )

    [142] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 953399360
        )

    [143] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 960440384
        )

    [144] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 967497792
        )

    [145] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 974526528
        )

    [146] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 981647680
        )

    [147] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 988655936
        )

    [148] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 995721792
        )

    [149] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1002443328
        )

    [150] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1009537600
        )

    [151] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1016545856
        )

    [152] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1023623744
        )

    [153] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1030664768
        )

    [154] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1037615680
        )

    [155] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1044779584
        )

    [156] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1051804224
        )

    [157] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1058857536
        )

    [158] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1065923136
        )

    [159] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1072973632
        )

    [160] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1080026944
        )

    [161] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1087096640
        )

    [162] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1094133568
        )

    [163] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1101199168
        )

    [164] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1108232000
        )

    [165] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1115264832
        )

    [166] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1122315584
        )

    [167] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1129368896
        )

    [168] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1136430400
        )

    [169] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1143508288
        )

    [170] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1150529344
        )

    [171] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1157582656
        )

    [172] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1164635968
        )

    [173] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1171709760
        )

    [174] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1178734400
        )

    [175] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1185713984
        )

    [176] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1191571264
        )

    [177] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1198583616
        )

    [178] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1205622848
        )

    [179] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1211611200
        )

    [180] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1219584832
        )

    [181] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1226646336
        )

    [182] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1233634112
        )

    [183] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1240580928
        )

    [184] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1247130432
        )

    [185] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1253176128
        )

    [186] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1257911104
        )

    [187] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1260507968
        )

    [188] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1269024320
        )

    [189] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1273837120
        )

    [190] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1280366144
        )

    [191] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1286141504
        )

    [192] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1293051456
        )

    [193] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1299973696
        )

    [194] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1306033472
        )

    [195] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1311194432
        )

    [196] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1317050176
        )

    [197] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1321082688
        )

    [198] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1321082688
        )

    [199] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1321082688
        )

    [200] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1321082688
        )

    [201] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1321082688
        )

    [202] => Array
        (
            [status] => pulling 74701a8c35f6
            [digest] => sha256:74701a8c35f6c8d9a4b91f3f3497643001d63e0c7a84e085bed452548fa88d45
            [total] => 1321082688
            [completed] => 1321082688
        )

    [203] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
        )

    [204] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
        )

    [205] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
        )

    [206] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
        )

    [207] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [208] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [209] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [210] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [211] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [212] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [213] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [214] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [215] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [216] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [217] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [218] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [219] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [220] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [221] => Array
        (
            [status] => pulling 966de95ca8a6
            [digest] => sha256:966de95ca8a62200913e3f8bfbf84c8494536f1b94b49166851e76644e966396
            [total] => 1429
            [completed] => 1429
        )

    [222] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
        )

    [223] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
        )

    [224] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
        )

    [225] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
        )

    [226] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
        )

    [227] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [228] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [229] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [230] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [231] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [232] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [233] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [234] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [235] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [236] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [237] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [238] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [239] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [240] => Array
        (
            [status] => pulling fcc5a6bec9da
            [digest] => sha256:fcc5a6bec9daf9b561a68827b67ab6088e1dba9d1fa2a50d7bbcc8384e0a265d
            [total] => 7711
            [completed] => 7711
        )

    [241] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
        )

    [242] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
        )

    [243] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
        )

    [244] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
        )

    [245] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
        )

    [246] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [247] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [248] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [249] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [250] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [251] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [252] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [253] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [254] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [255] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [256] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [257] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [258] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [259] => Array
        (
            [status] => pulling a70ff7e570d9
            [digest] => sha256:a70ff7e570d97baaf4e62ac6e6ad9975e04caa6d900d3742d37698494479e0cd
            [total] => 6016
            [completed] => 6016
        )

    [260] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
        )

    [261] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
        )

    [262] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
        )

    [263] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
        )

    [264] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [265] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [266] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [267] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [268] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [269] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [270] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [271] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [272] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [273] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [274] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [275] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [276] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [277] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [278] => Array
        (
            [status] => pulling 4f659a1e86d7
            [digest] => sha256:4f659a1e86d7f5a33c389f7991e7224b7ee6ad0358b53437d54c02d2e1b1118d
            [total] => 485
            [completed] => 485
        )

    [279] => Array
        (
            [status] => verifying sha256 digest
        )

    [280] => Array
        (
            [status] => writing manifest
        )

    [281] => Array
        (
            [status] => success
        )

)
```



### With streaming
#### Code
```php
try {
    foreach ($client->pull(model: 'mistral', insecure: true, stream: true) as $chunk) {
        echo $chunk->getChunk() . PHP_EOL;
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}
```

#### Result

```text
pulling ece5e659647a
pulling 715415638c9c
pulling 0b4284c1f870
pulling fefc914e46e6
pulling fbd313562bb7
verifying sha256 digest
writing manifest
success
```
