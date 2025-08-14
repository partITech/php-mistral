<?php

use Partitech\PhpMistral\Clients\Tei\TeiClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

require_once __DIR__ . '/../../../../vendor/autoload.php';


$teiUrl = getenv('TEI_SPLADE_POOLING_URI');
$apiKey = getenv('TEI_API_KEY');

$client = new TeiClient(apiKey: (string) $apiKey, url: $teiUrl);
try {
    $tokens = $client->embedSparse(inputs: 'What is Deep Learning?');
    var_dump($tokens);
} catch (MistralClientException $e) {
    echo $e->getMessage();
}

/*
array(1) {
  [0]=>
  array(1190) {
    [0]=>
    array(2) {
      ["index"]=>
      int(1003)
      ["value"]=>
      float(0.2055648)
    }
    [1]=>
    array(2) {
      ["index"]=>
      int(1005)
      ["value"]=>
      float(0.34785014)
    }
    [2]=>
    array(2) {
      ["index"]=>
      int(1006)
      ["value"]=>
      float(0.6190006)
    }
    [3]=>
    array(2) {
      ["index"]=>
      int(1007)
      ["value"]=>
      float(0.6800976)
    }
    [4]=>
    array(2) {
      ["index"]=>
      int(1010)
      ["value"]=>
      float(0.6601435)
    }
    [5]=>
    array(2) {
      ["index"]=>
      int(1011)
      ["value"]=>
      float(0.56410825)
    }
    [6]=>
    array(2) {
      ["index"]=>
      int(1012)
      ["value"]=>
      float(0.7738804)
    }
    [7]=>
    array(2) {
      ["index"]=>
      int(1015)
      ["value"]=>
      float(0.45136937)
    }
    [8]=>
    array(2) {
      ["index"]=>
      int(1016)
      ["value"]=>
      float(0.35609636)
    }
    [9]=>
    array(2) {
      ["index"]=>
      int(1017)
      ["value"]=>
      float(0.14736935)
    }
    [10]=>
    array(2) {
      ["index"]=>
      int(1018)
      ["value"]=>
      float(0.03770649)
    }
    [11]=>
    array(2) {
      ["index"]=>
      int(1019)
      ["value"]=>
      float(0.109333165)
    }
    [12]=>
    array(2) {
      ["index"]=>
      int(1024)
      ["value"]=>
      float(0.2220532)
    }
    [13]=>
    array(2) {
      ["index"]=>
      int(1025)
      ["value"]=>
      float(0.058422577)
    }
    [14]=>
    array(2) {
      ["index"]=>
      int(1037)
      ["value"]=>
      float(0.3204651)
    }
    [15]=>
    array(2) {
      ["index"]=>
      int(1038)
      ["value"]=>
      float(0.23292829)
    }
    [16]=>
    array(2) {
      ["index"]=>
      int(1039)
      ["value"]=>
      float(0.104058735)
    }
    [17]=>
    array(2) {
      ["index"]=>
      int(1040)
      ["value"]=>
      float(0.26412395)
    }
    [18]=>
    array(2) {
      ["index"]=>
      int(1041)
      ["value"]=>
      float(0.15500858)
    }
    [19]=>
    array(2) {
      ["index"]=>
      int(1042)
      ["value"]=>
      float(0.05738609)
    }
    [20]=>
    array(2) {
      ["index"]=>
      int(1043)
      ["value"]=>
      float(0.060069542)
    }
    [21]=>
    array(2) {
      ["index"]=>
      int(1044)
      ["value"]=>
      float(0.012889287)
    }
    [22]=>
    array(2) {
      ["index"]=>
      int(1045)
      ["value"]=>
      float(0.37054494)
    }
    [23]=>
    array(2) {
      ["index"]=>
      int(1046)
      ["value"]=>
      float(0.031298757)
    }
    [24]=>
    array(2) {
      ["index"]=>
      int(1047)
      ["value"]=>
      float(0.037137043)
    }
    [25]=>
    array(2) {
      ["index"]=>
      int(1048)
      ["value"]=>
      float(0.055078406)
    }
    [26]=>
    array(2) {
      ["index"]=>
      int(1050)
      ["value"]=>
      float(0.054989725)
    }
    [27]=>
    array(2) {
      ["index"]=>
      int(1051)
      ["value"]=>
      float(0.1446741)
    }
    [28]=>
    array(2) {
      ["index"]=>
      int(1052)
      ["value"]=>
      float(0.082227826)
    }
    [29]=>
    array(2) {
      ["index"]=>
      int(1054)
      ["value"]=>
      float(0.031395342)
    }
    [30]=>
    array(2) {
      ["index"]=>
      int(1055)
      ["value"]=>
      float(0.0028937869)
    }
    [31]=>
    array(2) {
      ["index"]=>
      int(1057)
      ["value"]=>
      float(0.057226803)
    }
    [32]=>
    array(2) {
      ["index"]=>
      int(1058)
      ["value"]=>
      float(0.0487975)
    }
    [33]=>
    array(2) {
      ["index"]=>
      int(1059)
      ["value"]=>
      float(0.13146755)
    }
    [34]=>
    array(2) {
      ["index"]=>
      int(1060)
      ["value"]=>
      float(0.015676713)
    }
    [35]=>
    array(2) {
      ["index"]=>
      int(1061)
      ["value"]=>
      float(0.03850849)
    }
    [36]=>
    array(2) {
      ["index"]=>
      int(1062)
      ["value"]=>
      float(0.047311626)
    }
    [37]=>
    array(2) {
      ["index"]=>
      int(1516)
      ["value"]=>
      float(0.07405865)
    }
    [38]=>
    array(2) {
      ["index"]=>
      int(1517)
      ["value"]=>
      float(0.19994828)
    }
    [39]=>
    array(2) {
      ["index"]=>
      int(1521)
      ["value"]=>
      float(0.19182299)
    }
    [40]=>
    array(2) {
      ["index"]=>
      int(1529)
      ["value"]=>
      float(0.004437125)
    }
    [41]=>
    array(2) {
      ["index"]=>
      int(1996)
      ["value"]=>
      float(0.6424223)
    }
    [42]=>
    array(2) {
      ["index"]=>
      int(1997)
      ["value"]=>
      float(0.48766592)
    }
    [43]=>
    array(2) {
      ["index"]=>
      int(1998)
      ["value"]=>
      float(0.52447045)
    }
    [44]=>
    array(2) {
      ["index"]=>
      int(1999)
      ["value"]=>
      float(0.6007846)
    }
    [45]=>
    array(2) {
      ["index"]=>
      int(2000)
      ["value"]=>
      float(0.48260516)
    }
    [46]=>
    array(2) {
      ["index"]=>
      int(2001)
      ["value"]=>
      float(0.53214276)
    }
    [47]=>
    array(2) {
      ["index"]=>
      int(2002)
      ["value"]=>
      float(0.48136058)
    }
    [48]=>
    array(2) {
      ["index"]=>
      int(2003)
      ["value"]=>
      float(0.64322907)
    }
    [49]=>
    array(2) {
      ["index"]=>
      int(2004)
      ["value"]=>
      float(0.32968)
    }
    [50]=>
    array(2) {
      ["index"]=>
      int(2005)
      ["value"]=>
      float(0.33716723)
    }
    [51]=>
    array(2) {
      ["index"]=>
      int(2006)
      ["value"]=>
      float(0.21924134)
    }
    [52]=>
    array(2) {
      ["index"]=>
      int(2007)
      ["value"]=>
      float(0.36093026)
    }
    [53]=>
    array(2) {
      ["index"]=>
      int(2008)
      ["value"]=>
      float(0.37581795)
    }
    [54]=>
    array(2) {
      ["index"]=>
      int(2009)
      ["value"]=>
      float(0.16524564)
    }
    [55]=>
    array(2) {
      ["index"]=>
      int(2010)
      ["value"]=>
      float(0.31512865)
    }
    [56]=>
    array(2) {
      ["index"]=>
      int(2011)
      ["value"]=>
      float(0.24142183)
    }
    [57]=>
    array(2) {
      ["index"]=>
      int(2012)
      ["value"]=>
      float(0.23120244)
    }
    [58]=>
    array(2) {
      ["index"]=>
      int(2013)
      ["value"]=>
      float(0.103172064)
    }
    [59]=>
    array(2) {
      ["index"]=>
      int(2014)
      ["value"]=>
      float(0.3640818)
    }
    [60]=>
    array(2) {
      ["index"]=>
      int(2015)
      ["value"]=>
      float(0.59817433)
    }
    [61]=>
    array(2) {
      ["index"]=>
      int(2016)
      ["value"]=>
      float(0.2416693)
    }
    [62]=>
    array(2) {
      ["index"]=>
      int(2018)
      ["value"]=>
      float(0.33935496)
    }
    [63]=>
    array(2) {
      ["index"]=>
      int(2019)
      ["value"]=>
      float(0.16805114)
    }
    [64]=>
    array(2) {
      ["index"]=>
      int(2020)
      ["value"]=>
      float(0.23914003)
    }
    [65]=>
    array(2) {
      ["index"]=>
      int(2022)
      ["value"]=>
      float(0.017452946)
    }
    [66]=>
    array(2) {
      ["index"]=>
      int(2023)
      ["value"]=>
      float(0.101102464)
    }
    [67]=>
    array(2) {
      ["index"]=>
      int(2024)
      ["value"]=>
      float(0.29653272)
    }
    [68]=>
    array(2) {
      ["index"]=>
      int(2025)
      ["value"]=>
      float(0.27716666)
    }
    [69]=>
    array(2) {
      ["index"]=>
      int(2028)
      ["value"]=>
      float(0.3382246)
    }
    [70]=>
    array(2) {
      ["index"]=>
      int(2030)
      ["value"]=>
      float(0.36240697)
    }
    [71]=>
    array(2) {
      ["index"]=>
      int(2031)
      ["value"]=>
      float(0.21302506)
    }
    [72]=>
    array(2) {
      ["index"]=>
      int(2032)
      ["value"]=>
      float(0.1589546)
    }
    [73]=>
    array(2) {
      ["index"]=>
      int(2033)
      ["value"]=>
      float(0.0670773)
    }
    [74]=>
    array(2) {
      ["index"]=>
      int(2034)
      ["value"]=>
      float(0.01049063)
    }
    [75]=>
    array(2) {
      ["index"]=>
      int(2035)
      ["value"]=>
      float(0.34477407)
    }
    [76]=>
    array(2) {
      ["index"]=>
      int(2036)
      ["value"]=>
      float(0.12603515)
    }
    [77]=>
    array(2) {
      ["index"]=>
      int(2037)
      ["value"]=>
      float(0.0042900676)
    }
    [78]=>
    array(2) {
      ["index"]=>
      int(2038)
      ["value"]=>
      float(0.11532505)
    }
    [79]=>
    array(2) {
      ["index"]=>
      int(2039)
      ["value"]=>
      float(0.17912088)
    }
    [80]=>
    array(2) {
      ["index"]=>
      int(2044)
      ["value"]=>
      float(0.016072592)
    }
    [81]=>
    array(2) {
      ["index"]=>
      int(2045)
      ["value"]=>
      float(0.3129342)
    }
    [82]=>
    array(2) {
      ["index"]=>
      int(2047)
      ["value"]=>
      float(0.27987555)
    }
    [83]=>
    array(2) {
      ["index"]=>
      int(2048)
      ["value"]=>
      float(0.15428367)
    }
    [84]=>
    array(2) {
      ["index"]=>
      int(2050)
      ["value"]=>
      float(0.18342358)
    }
    [85]=>
    array(2) {
      ["index"]=>
      int(2051)
      ["value"]=>
      float(0.3202882)
    }
    [86]=>
    array(2) {
      ["index"]=>
      int(2053)
      ["value"]=>
      float(0.20532736)
    }
    [87]=>
    array(2) {
      ["index"]=>
      int(2055)
      ["value"]=>
      float(0.02967138)
    }
    [88]=>
    array(2) {
      ["index"]=>
      int(2056)
      ["value"]=>
      float(0.36273175)
    }
    [89]=>
    array(2) {
      ["index"]=>
      int(2058)
      ["value"]=>
      float(0.21656622)
    }
    [90]=>
    array(2) {
      ["index"]=>
      int(2059)
      ["value"]=>
      float(0.0360495)
    }
    [91]=>
    array(2) {
      ["index"]=>
      int(2060)
      ["value"]=>
      float(0.25557446)
    }
    [92]=>
    array(2) {
      ["index"]=>
      int(2061)
      ["value"]=>
      float(0.18837763)
    }
    [93]=>
    array(2) {
      ["index"]=>
      int(2062)
      ["value"]=>
      float(0.28407887)
    }
    [94]=>
    array(2) {
      ["index"]=>
      int(2063)
      ["value"]=>
      float(0.17389545)
    }
    [95]=>
    array(2) {
      ["index"]=>
      int(2064)
      ["value"]=>
      float(0.2897004)
    }
    [96]=>
    array(2) {
      ["index"]=>
      int(2066)
      ["value"]=>
      float(0.049502168)
    }
    [97]=>
    array(2) {
      ["index"]=>
      int(2067)
      ["value"]=>
      float(0.18960945)
    }
    [98]=>
    array(2) {
      ["index"]=>
      int(2069)
      ["value"]=>
      float(0.17458747)
    }
    [99]=>
    array(2) {
      ["index"]=>
      int(2072)
      ["value"]=>
      float(0.12890491)
    }
    [100]=>
    array(2) {
      ["index"]=>
      int(2075)
      ["value"]=>
      float(0.08119672)
    }
    [101]=>
    array(2) {
      ["index"]=>
      int(2078)
      ["value"]=>
      float(0.104856715)
    }
    [102]=>
    array(2) {
      ["index"]=>
      int(2079)
      ["value"]=>
      float(0.039606657)
    }
    [103]=>
    array(2) {
      ["index"]=>
      int(2080)
      ["value"]=>
      float(0.18256794)
    }
    [104]=>
    array(2) {
      ["index"]=>
      int(2081)
      ["value"]=>
      float(0.15267725)
    }
    [105]=>
    array(2) {
      ["index"]=>
      int(2082)
      ["value"]=>
      float(0.29982933)
    }
    [106]=>
    array(2) {
      ["index"]=>
      int(2086)
      ["value"]=>
      float(0.25644302)
    }
    [107]=>
    array(2) {
      ["index"]=>
      int(2087)
      ["value"]=>
      float(0.19207202)
    }
    [108]=>
    array(2) {
      ["index"]=>
      int(2089)
      ["value"]=>
      float(0.10106906)
    }
    [109]=>
    array(2) {
      ["index"]=>
      int(2091)
      ["value"]=>
      float(0.043765277)
    }
    [110]=>
    array(2) {
      ["index"]=>
      int(2092)
      ["value"]=>
      float(0.21590073)
    }
    [111]=>
    array(2) {
      ["index"]=>
      int(2093)
      ["value"]=>
      float(0.028177887)
    }
    [112]=>
    array(2) {
      ["index"]=>
      int(2094)
      ["value"]=>
      float(0.13290915)
    }
    [113]=>
    array(2) {
      ["index"]=>
      int(2095)
      ["value"]=>
      float(0.08055749)
    }
    [114]=>
    array(2) {
      ["index"]=>
      int(2096)
      ["value"]=>
      float(0.034239672)
    }
    [115]=>
    array(2) {
      ["index"]=>
      int(2097)
      ["value"]=>
      float(0.19422367)
    }
    [116]=>
    array(2) {
      ["index"]=>
      int(2098)
      ["value"]=>
      float(0.018456275)
    }
    [117]=>
    array(2) {
      ["index"]=>
      int(2100)
      ["value"]=>
      float(0.031914607)
    }
    [118]=>
    array(2) {
      ["index"]=>
      int(2101)
      ["value"]=>
      float(0.2129795)
    }
    [119]=>
    array(2) {
      ["index"]=>
      int(2102)
      ["value"]=>
      float(0.024322448)
    }
    [120]=>
    array(2) {
      ["index"]=>
      int(2103)
      ["value"]=>
      float(0.15047443)
    }
    [121]=>
    array(2) {
      ["index"]=>
      int(2107)
      ["value"]=>
      float(0.19522475)
    }
    [122]=>
    array(2) {
      ["index"]=>
      int(2109)
      ["value"]=>
      float(0.25361425)
    }
    [123]=>
    array(2) {
      ["index"]=>
      int(2110)
      ["value"]=>
      float(0.14476654)
    }
    [124]=>
    array(2) {
      ["index"]=>
      int(2111)
      ["value"]=>
      float(0.28931272)
    }
    [125]=>
    array(2) {
      ["index"]=>
      int(2112)
      ["value"]=>
      float(0.13685574)
    }
    [126]=>
    array(2) {
      ["index"]=>
      int(2116)
      ["value"]=>
      float(0.044033956)
    }
    [127]=>
    array(2) {
      ["index"]=>
      int(2117)
      ["value"]=>
      float(0.04292477)
    }
    [128]=>
    array(2) {
      ["index"]=>
      int(2121)
      ["value"]=>
      float(0.13015765)
    }
    [129]=>
    array(2) {
      ["index"]=>
      int(2124)
      ["value"]=>
      float(0.07386878)
    }
    [130]=>
    array(2) {
      ["index"]=>
      int(2126)
      ["value"]=>
      float(0.13467515)
    }
    [131]=>
    array(2) {
      ["index"]=>
      int(2128)
      ["value"]=>
      float(0.2586882)
    }
    [132]=>
    array(2) {
      ["index"]=>
      int(2130)
      ["value"]=>
      float(0.059105556)
    }
    [133]=>
    array(2) {
      ["index"]=>
      int(2135)
      ["value"]=>
      float(0.175755)
    }
    [134]=>
    array(2) {
      ["index"]=>
      int(2136)
      ["value"]=>
      float(0.14460036)
    }
    [135]=>
    array(2) {
      ["index"]=>
      int(2137)
      ["value"]=>
      float(0.32704693)
    }
    [136]=>
    array(2) {
      ["index"]=>
      int(2139)
      ["value"]=>
      float(0.19963911)
    }
    [137]=>
    array(2) {
      ["index"]=>
      int(2140)
      ["value"]=>
      float(0.007598663)
    }
    [138]=>
    array(2) {
      ["index"]=>
      int(2143)
      ["value"]=>
      float(0.21994583)
    }
    [139]=>
    array(2) {
      ["index"]=>
      int(2146)
      ["value"]=>
      float(0.15699098)
    }
    [140]=>
    array(2) {
      ["index"]=>
      int(2147)
      ["value"]=>
      float(0.19137822)
    }
    [141]=>
    array(2) {
      ["index"]=>
      int(2148)
      ["value"]=>
      float(0.1014474)
    }
    [142]=>
    array(2) {
      ["index"]=>
      int(2149)
      ["value"]=>
      float(0.11149502)
    }
    [143]=>
    array(2) {
      ["index"]=>
      int(2152)
      ["value"]=>
      float(0.074025)
    }
    [144]=>
    array(2) {
      ["index"]=>
      int(2154)
      ["value"]=>
      float(0.16270033)
    }
    [145]=>
    array(2) {
      ["index"]=>
      int(2155)
      ["value"]=>
      float(0.21048808)
    }
    [146]=>
    array(2) {
      ["index"]=>
      int(2156)
      ["value"]=>
      float(0.04702426)
    }
    [147]=>
    array(2) {
      ["index"]=>
      int(2157)
      ["value"]=>
      float(0.019425625)
    }
    [148]=>
    array(2) {
      ["index"]=>
      int(2158)
      ["value"]=>
      float(0.09805323)
    }
    [149]=>
    array(2) {
      ["index"]=>
      int(2160)
      ["value"]=>
      float(0.13576406)
    }
    [150]=>
    array(2) {
      ["index"]=>
      int(2161)
      ["value"]=>
      float(0.17378674)
    }
    [151]=>
    array(2) {
      ["index"]=>
      int(2162)
      ["value"]=>
      float(0.19948289)
    }
    [152]=>
    array(2) {
      ["index"]=>
      int(2163)
      ["value"]=>
      float(0.033642888)
    }
    [153]=>
    array(2) {
      ["index"]=>
      int(2166)
      ["value"]=>
      float(0.22129849)
    }
    [154]=>
    array(2) {
      ["index"]=>
      int(2167)
      ["value"]=>
      float(0.088459454)
    }
    [155]=>
    array(2) {
      ["index"]=>
      int(2171)
      ["value"]=>
      float(0.3001228)
    }
    [156]=>
    array(2) {
      ["index"]=>
      int(2173)
      ["value"]=>
      float(0.031499423)
    }
    [157]=>
    array(2) {
      ["index"]=>
      int(2174)
      ["value"]=>
      float(0.07247395)
    }
    [158]=>
    array(2) {
      ["index"]=>
      int(2175)
      ["value"]=>
      float(0.04179492)
    }
    [159]=>
    array(2) {
      ["index"]=>
      int(2176)
      ["value"]=>
      float(0.013640056)
    }
    [160]=>
    array(2) {
      ["index"]=>
      int(2177)
      ["value"]=>
      float(0.24906318)
    }
    [161]=>
    array(2) {
      ["index"]=>
      int(2179)
      ["value"]=>
      float(0.46005872)
    }
    [162]=>
    array(2) {
      ["index"]=>
      int(2180)
      ["value"]=>
      float(0.2386006)
    }
    [163]=>
    array(2) {
      ["index"]=>
      int(2181)
      ["value"]=>
      float(0.1399032)
    }
    [164]=>
    array(2) {
      ["index"]=>
      int(2182)
      ["value"]=>
      float(0.074909575)
    }
    [165]=>
    array(2) {
      ["index"]=>
      int(2183)
      ["value"]=>
      float(0.07309366)
    }
    [166]=>
    array(2) {
      ["index"]=>
      int(2184)
      ["value"]=>
      float(0.09080915)
    }
    [167]=>
    array(2) {
      ["index"]=>
      int(2185)
      ["value"]=>
      float(0.0006071869)
    }
    [168]=>
    array(2) {
      ["index"]=>
      int(2186)
      ["value"]=>
      float(0.21809849)
    }
    [169]=>
    array(2) {
      ["index"]=>
      int(2187)
      ["value"]=>
      float(0.12976791)
    }
    [170]=>
    array(2) {
      ["index"]=>
      int(2188)
      ["value"]=>
      float(0.29641795)
    }
    [171]=>
    array(2) {
      ["index"]=>
      int(2189)
      ["value"]=>
      float(0.2635243)
    }
    [172]=>
    array(2) {
      ["index"]=>
      int(2190)
      ["value"]=>
      float(0.118211776)
    }
    [173]=>
    array(2) {
      ["index"]=>
      int(2192)
      ["value"]=>
      float(0.09125679)
    }
    [174]=>
    array(2) {
      ["index"]=>
      int(2193)
      ["value"]=>
      float(0.18676616)
    }
    [175]=>
    array(2) {
      ["index"]=>
      int(2194)
      ["value"]=>
      float(0.1793142)
    }
    [176]=>
    array(2) {
      ["index"]=>
      int(2202)
      ["value"]=>
      float(0.049134064)
    }
    [177]=>
    array(2) {
      ["index"]=>
      int(2203)
      ["value"]=>
      float(0.21844244)
    }
    [178]=>
    array(2) {
      ["index"]=>
      int(2206)
      ["value"]=>
      float(0.117814615)
    }
    [179]=>
    array(2) {
      ["index"]=>
      int(2207)
      ["value"]=>
      float(0.0088655185)
    }
    [180]=>
    array(2) {
      ["index"]=>
      int(2208)
      ["value"]=>
      float(0.22373733)
    }
    [181]=>
    array(2) {
      ["index"]=>
      int(2209)
      ["value"]=>
      float(0.04180818)
    }
    [182]=>
    array(2) {
      ["index"]=>
      int(2210)
      ["value"]=>
      float(0.006655786)
    }
    [183]=>
    array(2) {
      ["index"]=>
      int(2212)
      ["value"]=>
      float(0.115338005)
    }
    [184]=>
    array(2) {
      ["index"]=>
      int(2214)
      ["value"]=>
      float(0.1690402)
    }
    [185]=>
    array(2) {
      ["index"]=>
      int(2217)
      ["value"]=>
      float(0.1455295)
    }
    [186]=>
    array(2) {
      ["index"]=>
      int(2221)
      ["value"]=>
      float(0.28568393)
    }
    [187]=>
    array(2) {
      ["index"]=>
      int(2224)
      ["value"]=>
      float(0.16740924)
    }
    [188]=>
    array(2) {
      ["index"]=>
      int(2225)
      ["value"]=>
      float(0.18367152)
    }
    [189]=>
    array(2) {
      ["index"]=>
      int(2226)
      ["value"]=>
      float(0.04194548)
    }
    [190]=>
    array(2) {
      ["index"]=>
      int(2227)
      ["value"]=>
      float(0.035714943)
    }
    [191]=>
    array(2) {
      ["index"]=>
      int(2229)
      ["value"]=>
      float(0.060640328)
    }
    [192]=>
    array(2) {
      ["index"]=>
      int(2235)
      ["value"]=>
      float(0.03314182)
    }
    [193]=>
    array(2) {
      ["index"]=>
      int(2236)
      ["value"]=>
      float(0.16486378)
    }
    [194]=>
    array(2) {
      ["index"]=>
      int(2237)
      ["value"]=>
      float(0.10304324)
    }
    [195]=>
    array(2) {
      ["index"]=>
      int(2239)
      ["value"]=>
      float(0.106299214)
    }
    [196]=>
    array(2) {
      ["index"]=>
      int(2240)
      ["value"]=>
      float(0.10987215)
    }
    [197]=>
    array(2) {
      ["index"]=>
      int(2241)
      ["value"]=>
      float(0.0035988821)
    }
    [198]=>
    array(2) {
      ["index"]=>
      int(2243)
      ["value"]=>
      float(0.10372834)
    }
    [199]=>
    array(2) {
      ["index"]=>
      int(2248)
      ["value"]=>
      float(0.032168135)
    }
    [200]=>
    array(2) {
      ["index"]=>
      int(2250)
      ["value"]=>
      float(0.051707394)
    }
    [201]=>
    array(2) {
      ["index"]=>
      int(2252)
      ["value"]=>
      float(0.095066115)
    }
    [202]=>
    array(2) {
      ["index"]=>
      int(2260)
      ["value"]=>
      float(0.059729338)
    }
    [203]=>
    array(2) {
      ["index"]=>
      int(2262)
      ["value"]=>
      float(0.071892455)
    }
    [204]=>
    array(2) {
      ["index"]=>
      int(2263)
      ["value"]=>
      float(0.072924994)
    }
    [205]=>
    array(2) {
      ["index"]=>
      int(2264)
      ["value"]=>
      float(0.017536351)
    }
    [206]=>
    array(2) {
      ["index"]=>
      int(2265)
      ["value"]=>
      float(0.081068665)
    }
    [207]=>
    array(2) {
      ["index"]=>
      int(2266)
      ["value"]=>
      float(0.20127541)
    }
    [208]=>
    array(2) {
      ["index"]=>
      int(2267)
      ["value"]=>
      float(0.052707825)
    }
    [209]=>
    array(2) {
      ["index"]=>
      int(2268)
      ["value"]=>
      float(0.05790014)
    }
    [210]=>
    array(2) {
      ["index"]=>
      int(2269)
      ["value"]=>
      float(0.023513176)
    }
    [211]=>
    array(2) {
      ["index"]=>
      int(2270)
      ["value"]=>
      float(0.0016105312)
    }
    [212]=>
    array(2) {
      ["index"]=>
      int(2271)
      ["value"]=>
      float(0.20019421)
    }
    [213]=>
    array(2) {
      ["index"]=>
      int(2272)
      ["value"]=>
      float(0.019035753)
    }
    [214]=>
    array(2) {
      ["index"]=>
      int(2273)
      ["value"]=>
      float(0.13575178)
    }
    [215]=>
    array(2) {
      ["index"]=>
      int(2275)
      ["value"]=>
      float(0.14799413)
    }
    [216]=>
    array(2) {
      ["index"]=>
      int(2276)
      ["value"]=>
      float(0.15438563)
    }
    [217]=>
    array(2) {
      ["index"]=>
      int(2277)
      ["value"]=>
      float(0.035235282)
    }
    [218]=>
    array(2) {
      ["index"]=>
      int(2278)
      ["value"]=>
      float(0.05258455)
    }
    [219]=>
    array(2) {
      ["index"]=>
      int(2283)
      ["value"]=>
      float(0.06615185)
    }
    [220]=>
    array(2) {
      ["index"]=>
      int(2284)
      ["value"]=>
      float(0.06480888)
    }
    [221]=>
    array(2) {
      ["index"]=>
      int(2287)
      ["value"]=>
      float(0.29549995)
    }
    [222]=>
    array(2) {
      ["index"]=>
      int(2288)
      ["value"]=>
      float(0.054986004)
    }
    [223]=>
    array(2) {
      ["index"]=>
      int(2291)
      ["value"]=>
      float(0.06251403)
    }
    [224]=>
    array(2) {
      ["index"]=>
      int(2292)
      ["value"]=>
      float(0.045502607)
    }
    [225]=>
    array(2) {
      ["index"]=>
      int(2293)
      ["value"]=>
      float(0.20462346)
    }
    [226]=>
    array(2) {
      ["index"]=>
      int(2298)
      ["value"]=>
      float(0.04713401)
    }
    [227]=>
    array(2) {
      ["index"]=>
      int(2299)
      ["value"]=>
      float(0.10861447)
    }
    [228]=>
    array(2) {
      ["index"]=>
      int(2300)
      ["value"]=>
      float(0.18970768)
    }
    [229]=>
    array(2) {
      ["index"]=>
      int(2301)
      ["value"]=>
      float(0.14453402)
    }
    [230]=>
    array(2) {
      ["index"]=>
      int(2303)
      ["value"]=>
      float(0.08684562)
    }
    [231]=>
    array(2) {
      ["index"]=>
      int(2304)
      ["value"]=>
      float(0.15757921)
    }
    [232]=>
    array(2) {
      ["index"]=>
      int(2305)
      ["value"]=>
      float(0.089150146)
    }
    [233]=>
    array(2) {
      ["index"]=>
      int(2307)
      ["value"]=>
      float(0.10857886)
    }
    [234]=>
    array(2) {
      ["index"]=>
      int(2308)
      ["value"]=>
      float(0.12256212)
    }
    [235]=>
    array(2) {
      ["index"]=>
      int(2309)
      ["value"]=>
      float(0.081243545)
    }
    [236]=>
    array(2) {
      ["index"]=>
      int(2311)
      ["value"]=>
      float(0.10519157)
    }
    [237]=>
    array(2) {
      ["index"]=>
      int(2314)
      ["value"]=>
      float(0.24701782)
    }
    [238]=>
    array(2) {
      ["index"]=>
      int(2315)
      ["value"]=>
      float(0.017904563)
    }
    [239]=>
    array(2) {
      ["index"]=>
      int(2316)
      ["value"]=>
      float(0.16396084)
    }
    [240]=>
    array(2) {
      ["index"]=>
      int(2317)
      ["value"]=>
      float(0.22598632)
    }
    [241]=>
    array(2) {
      ["index"]=>
      int(2321)
      ["value"]=>
      float(0.006934623)
    }
    [242]=>
    array(2) {
      ["index"]=>
      int(2322)
      ["value"]=>
      float(0.03897581)
    }
    [243]=>
    array(2) {
      ["index"]=>
      int(2326)
      ["value"]=>
      float(0.16740681)
    }
    [244]=>
    array(2) {
      ["index"]=>
      int(2329)
      ["value"]=>
      float(0.03810912)
    }
    [245]=>
    array(2) {
      ["index"]=>
      int(2330)
      ["value"]=>
      float(0.07587083)
    }
    [246]=>
    array(2) {
      ["index"]=>
      int(2331)
      ["value"]=>
      float(0.2425199)
    }
    [247]=>
    array(2) {
      ["index"]=>
      int(2332)
      ["value"]=>
      float(0.080877155)
    }
    [248]=>
    array(2) {
      ["index"]=>
      int(2334)
      ["value"]=>
      float(0.052787438)
    }
    [249]=>
    array(2) {
      ["index"]=>
      int(2336)
      ["value"]=>
      float(0.16329768)
    }
    [250]=>
    array(2) {
      ["index"]=>
      int(2338)
      ["value"]=>
      float(0.10710655)
    }
    [251]=>
    array(2) {
      ["index"]=>
      int(2342)
      ["value"]=>
      float(0.03446232)
    }
    [252]=>
    array(2) {
      ["index"]=>
      int(2343)
      ["value"]=>
      float(0.16767682)
    }
    [253]=>
    array(2) {
      ["index"]=>
      int(2344)
      ["value"]=>
      float(0.14511964)
    }
    [254]=>
    array(2) {
      ["index"]=>
      int(2345)
      ["value"]=>
      float(0.27510124)
    }
    [255]=>
    array(2) {
      ["index"]=>
      int(2346)
      ["value"]=>
      float(0.05896385)
    }
    [256]=>
    array(2) {
      ["index"]=>
      int(2350)
      ["value"]=>
      float(0.003556595)
    }
    [257]=>
    array(2) {
      ["index"]=>
      int(2351)
      ["value"]=>
      float(0.18189235)
    }
    [258]=>
    array(2) {
      ["index"]=>
      int(2352)
      ["value"]=>
      float(0.202758)
    }
    [259]=>
    array(2) {
      ["index"]=>
      int(2355)
      ["value"]=>
      float(0.017217219)
    }
    [260]=>
    array(2) {
      ["index"]=>
      int(2356)
      ["value"]=>
      float(0.032022674)
    }
    [261]=>
    array(2) {
      ["index"]=>
      int(2358)
      ["value"]=>
      float(0.33175448)
    }
    [262]=>
    array(2) {
      ["index"]=>
      int(2360)
      ["value"]=>
      float(0.025103863)
    }
    [263]=>
    array(2) {
      ["index"]=>
      int(2365)
      ["value"]=>
      float(0.020590015)
    }
    [264]=>
    array(2) {
      ["index"]=>
      int(2368)
      ["value"]=>
      float(0.0604259)
    }
    [265]=>
    array(2) {
      ["index"]=>
      int(2372)
      ["value"]=>
      float(0.028479986)
    }
    [266]=>
    array(2) {
      ["index"]=>
      int(2373)
      ["value"]=>
      float(0.19257726)
    }
    [267]=>
    array(2) {
      ["index"]=>
      int(2374)
      ["value"]=>
      float(0.025217902)
    }
    [268]=>
    array(2) {
      ["index"]=>
      int(2375)
      ["value"]=>
      float(0.17894645)
    }
    [269]=>
    array(2) {
      ["index"]=>
      int(2377)
      ["value"]=>
      float(0.14973915)
    }
    [270]=>
    array(2) {
      ["index"]=>
      int(2378)
      ["value"]=>
      float(0.1683813)
    }
    [271]=>
    array(2) {
      ["index"]=>
      int(2380)
      ["value"]=>
      float(0.054089267)
    }
    [272]=>
    array(2) {
      ["index"]=>
      int(2381)
      ["value"]=>
      float(0.1525518)
    }
    [273]=>
    array(2) {
      ["index"]=>
      int(2384)
      ["value"]=>
      float(0.008272194)
    }
    [274]=>
    array(2) {
      ["index"]=>
      int(2386)
      ["value"]=>
      float(0.053099714)
    }
    [275]=>
    array(2) {
      ["index"]=>
      int(2388)
      ["value"]=>
      float(0.013443301)
    }
    [276]=>
    array(2) {
      ["index"]=>
      int(2390)
      ["value"]=>
      float(0.086138025)
    }
    [277]=>
    array(2) {
      ["index"]=>
      int(2391)
      ["value"]=>
      float(0.04871121)
    }
    [278]=>
    array(2) {
      ["index"]=>
      int(2393)
      ["value"]=>
      float(0.15325965)
    }
    [279]=>
    array(2) {
      ["index"]=>
      int(2394)
      ["value"]=>
      float(0.03347136)
    }
    [280]=>
    array(2) {
      ["index"]=>
      int(2395)
      ["value"]=>
      float(0.08844461)
    }
    [281]=>
    array(2) {
      ["index"]=>
      int(2396)
      ["value"]=>
      float(0.23494026)
    }
    [282]=>
    array(2) {
      ["index"]=>
      int(2399)
      ["value"]=>
      float(0.08790739)
    }
    [283]=>
    array(2) {
      ["index"]=>
      int(2401)
      ["value"]=>
      float(0.09411577)
    }
    [284]=>
    array(2) {
      ["index"]=>
      int(2402)
      ["value"]=>
      float(0.16553065)
    }
    [285]=>
    array(2) {
      ["index"]=>
      int(2404)
      ["value"]=>
      float(0.040538903)
    }
    [286]=>
    array(2) {
      ["index"]=>
      int(2406)
      ["value"]=>
      float(0.09430964)
    }
    [287]=>
    array(2) {
      ["index"]=>
      int(2407)
      ["value"]=>
      float(0.031643573)
    }
    [288]=>
    array(2) {
      ["index"]=>
      int(2411)
      ["value"]=>
      float(0.07749705)
    }
    [289]=>
    array(2) {
      ["index"]=>
      int(2413)
      ["value"]=>
      float(0.13655712)
    }
    [290]=>
    array(2) {
      ["index"]=>
      int(2414)
      ["value"]=>
      float(0.1735208)
    }
    [291]=>
    array(2) {
      ["index"]=>
      int(2415)
      ["value"]=>
      float(0.078296)
    }
    [292]=>
    array(2) {
      ["index"]=>
      int(2417)
      ["value"]=>
      float(0.15409148)
    }
    [293]=>
    array(2) {
      ["index"]=>
      int(2419)
      ["value"]=>
      float(0.016029889)
    }
    [294]=>
    array(2) {
      ["index"]=>
      int(2422)
      ["value"]=>
      float(0.13460274)
    }
    [295]=>
    array(2) {
      ["index"]=>
      int(2427)
      ["value"]=>
      float(0.0361339)
    }
    [296]=>
    array(2) {
      ["index"]=>
      int(2430)
      ["value"]=>
      float(0.031368423)
    }
    [297]=>
    array(2) {
      ["index"]=>
      int(2431)
      ["value"]=>
      float(0.04386614)
    }
    [298]=>
    array(2) {
      ["index"]=>
      int(2433)
      ["value"]=>
      float(0.15827477)
    }
    [299]=>
    array(2) {
      ["index"]=>
      int(2436)
      ["value"]=>
      float(0.16347556)
    }
    [300]=>
    array(2) {
      ["index"]=>
      int(2437)
      ["value"]=>
      float(0.057562683)
    }
    [301]=>
    array(2) {
      ["index"]=>
      int(2439)
      ["value"]=>
      float(0.14233188)
    }
    [302]=>
    array(2) {
      ["index"]=>
      int(2444)
      ["value"]=>
      float(0.09226258)
    }
    [303]=>
    array(2) {
      ["index"]=>
      int(2445)
      ["value"]=>
      float(0.059707217)
    }
    [304]=>
    array(2) {
      ["index"]=>
      int(2446)
      ["value"]=>
      float(0.18360466)
    }
    [305]=>
    array(2) {
      ["index"]=>
      int(2448)
      ["value"]=>
      float(0.06254796)
    }
    [306]=>
    array(2) {
      ["index"]=>
      int(2450)
      ["value"]=>
      float(0.09382592)
    }
    [307]=>
    array(2) {
      ["index"]=>
      int(2451)
      ["value"]=>
      float(0.15598564)
    }
    [308]=>
    array(2) {
      ["index"]=>
      int(2452)
      ["value"]=>
      float(0.10486487)
    }
    [309]=>
    array(2) {
      ["index"]=>
      int(2455)
      ["value"]=>
      float(0.10547493)
    }
    [310]=>
    array(2) {
      ["index"]=>
      int(2457)
      ["value"]=>
      float(0.14064193)
    }
    [311]=>
    array(2) {
      ["index"]=>
      int(2458)
      ["value"]=>
      float(0.062482)
    }
    [312]=>
    array(2) {
      ["index"]=>
      int(2460)
      ["value"]=>
      float(0.08403437)
    }
    [313]=>
    array(2) {
      ["index"]=>
      int(2461)
      ["value"]=>
      float(0.22992752)
    }
    [314]=>
    array(2) {
      ["index"]=>
      int(2465)
      ["value"]=>
      float(0.21262567)
    }
    [315]=>
    array(2) {
      ["index"]=>
      int(2470)
      ["value"]=>
      float(0.06372397)
    }
    [316]=>
    array(2) {
      ["index"]=>
      int(2474)
      ["value"]=>
      float(0.057943787)
    }
    [317]=>
    array(2) {
      ["index"]=>
      int(2478)
      ["value"]=>
      float(0.01433797)
    }
    [318]=>
    array(2) {
      ["index"]=>
      int(2479)
      ["value"]=>
      float(0.16241115)
    }
    [319]=>
    array(2) {
      ["index"]=>
      int(2480)
      ["value"]=>
      float(0.011851141)
    }
    [320]=>
    array(2) {
      ["index"]=>
      int(2482)
      ["value"]=>
      float(0.14082274)
    }
    [321]=>
    array(2) {
      ["index"]=>
      int(2486)
      ["value"]=>
      float(0.112277925)
    }
    [322]=>
    array(2) {
      ["index"]=>
      int(2488)
      ["value"]=>
      float(0.06995535)
    }
    [323]=>
    array(2) {
      ["index"]=>
      int(2489)
      ["value"]=>
      float(0.068392955)
    }
    [324]=>
    array(2) {
      ["index"]=>
      int(2490)
      ["value"]=>
      float(0.13250223)
    }
    [325]=>
    array(2) {
      ["index"]=>
      int(2491)
      ["value"]=>
      float(0.18096785)
    }
    [326]=>
    array(2) {
      ["index"]=>
      int(2492)
      ["value"]=>
      float(0.04473937)
    }
    [327]=>
    array(2) {
      ["index"]=>
      int(2493)
      ["value"]=>
      float(0.039649393)
    }
    [328]=>
    array(2) {
      ["index"]=>
      int(2494)
      ["value"]=>
      float(0.016054057)
    }
    [329]=>
    array(2) {
      ["index"]=>
      int(2495)
      ["value"]=>
      float(0.04314641)
    }
    [330]=>
    array(2) {
      ["index"]=>
      int(2496)
      ["value"]=>
      float(0.087449506)
    }
    [331]=>
    array(2) {
      ["index"]=>
      int(2500)
      ["value"]=>
      float(0.100432165)
    }
    [332]=>
    array(2) {
      ["index"]=>
      int(2504)
      ["value"]=>
      float(0.043770753)
    }
    [333]=>
    array(2) {
      ["index"]=>
      int(2506)
      ["value"]=>
      float(0.025455587)
    }
    [334]=>
    array(2) {
      ["index"]=>
      int(2520)
      ["value"]=>
      float(0.0065307287)
    }
    [335]=>
    array(2) {
      ["index"]=>
      int(2521)
      ["value"]=>
      float(0.07182623)
    }
    [336]=>
    array(2) {
      ["index"]=>
      int(2522)
      ["value"]=>
      float(0.13043255)
    }
    [337]=>
    array(2) {
      ["index"]=>
      int(2523)
      ["value"]=>
      float(0.0026971651)
    }
    [338]=>
    array(2) {
      ["index"]=>
      int(2527)
      ["value"]=>
      float(0.041537985)
    }
    [339]=>
    array(2) {
      ["index"]=>
      int(2529)
      ["value"]=>
      float(0.019566616)
    }
    [340]=>
    array(2) {
      ["index"]=>
      int(2531)
      ["value"]=>
      float(0.057550415)
    }
    [341]=>
    array(2) {
      ["index"]=>
      int(2532)
      ["value"]=>
      float(0.028676584)
    }
    [342]=>
    array(2) {
      ["index"]=>
      int(2534)
      ["value"]=>
      float(0.048744477)
    }
    [343]=>
    array(2) {
      ["index"]=>
      int(2537)
      ["value"]=>
      float(0.086346686)
    }
    [344]=>
    array(2) {
      ["index"]=>
      int(2540)
      ["value"]=>
      float(0.027742019)
    }
    [345]=>
    array(2) {
      ["index"]=>
      int(2542)
      ["value"]=>
      float(0.084541366)
    }
    [346]=>
    array(2) {
      ["index"]=>
      int(2543)
      ["value"]=>
      float(0.014626304)
    }
    [347]=>
    array(2) {
      ["index"]=>
      int(2544)
      ["value"]=>
      float(0.03147505)
    }
    [348]=>
    array(2) {
      ["index"]=>
      int(2546)
      ["value"]=>
      float(0.0057825423)
    }
    [349]=>
    array(2) {
      ["index"]=>
      int(2548)
      ["value"]=>
      float(0.0007656265)
    }
    [350]=>
    array(2) {
      ["index"]=>
      int(2551)
      ["value"]=>
      float(0.08991347)
    }
    [351]=>
    array(2) {
      ["index"]=>
      int(2552)
      ["value"]=>
      float(0.23418815)
    }
    [352]=>
    array(2) {
      ["index"]=>
      int(2553)
      ["value"]=>
      float(0.08994594)
    }
    [353]=>
    array(2) {
      ["index"]=>
      int(2555)
      ["value"]=>
      float(0.04029333)
    }
    [354]=>
    array(2) {
      ["index"]=>
      int(2556)
      ["value"]=>
      float(0.17964426)
    }
    [355]=>
    array(2) {
      ["index"]=>
      int(2557)
      ["value"]=>
      float(0.2073392)
    }
    [356]=>
    array(2) {
      ["index"]=>
      int(2563)
      ["value"]=>
      float(0.011965288)
    }
    [357]=>
    array(2) {
      ["index"]=>
      int(2565)
      ["value"]=>
      float(0.030884244)
    }
    [358]=>
    array(2) {
      ["index"]=>
      int(2566)
      ["value"]=>
      float(0.082516335)
    }
    [359]=>
    array(2) {
      ["index"]=>
      int(2567)
      ["value"]=>
      float(0.025511833)
    }
    [360]=>
    array(2) {
      ["index"]=>
      int(2569)
      ["value"]=>
      float(0.02485691)
    }
    [361]=>
    array(2) {
      ["index"]=>
      int(2573)
      ["value"]=>
      float(0.1746162)
    }
    [362]=>
    array(2) {
      ["index"]=>
      int(2578)
      ["value"]=>
      float(0.16841897)
    }
    [363]=>
    array(2) {
      ["index"]=>
      int(2582)
      ["value"]=>
      float(0.008430134)
    }
    [364]=>
    array(2) {
      ["index"]=>
      int(2585)
      ["value"]=>
      float(0.048621166)
    }
    [365]=>
    array(2) {
      ["index"]=>
      int(2586)
      ["value"]=>
      float(0.08890521)
    }
    [366]=>
    array(2) {
      ["index"]=>
      int(2590)
      ["value"]=>
      float(0.02624413)
    }
    [367]=>
    array(2) {
      ["index"]=>
      int(2591)
      ["value"]=>
      float(0.019643767)
    }
    [368]=>
    array(2) {
      ["index"]=>
      int(2592)
      ["value"]=>
      float(0.16115275)
    }
    [369]=>
    array(2) {
      ["index"]=>
      int(2594)
      ["value"]=>
      float(0.05005759)
    }
    [370]=>
    array(2) {
      ["index"]=>
      int(2595)
      ["value"]=>
      float(0.14672258)
    }
    [371]=>
    array(2) {
      ["index"]=>
      int(2597)
      ["value"]=>
      float(0.0125930365)
    }
    [372]=>
    array(2) {
      ["index"]=>
      int(2598)
      ["value"]=>
      float(0.018731138)
    }
    [373]=>
    array(2) {
      ["index"]=>
      int(2600)
      ["value"]=>
      float(0.12303393)
    }
    [374]=>
    array(2) {
      ["index"]=>
      int(2609)
      ["value"]=>
      float(0.02912756)
    }
    [375]=>
    array(2) {
      ["index"]=>
      int(2610)
      ["value"]=>
      float(0.09310598)
    }
    [376]=>
    array(2) {
      ["index"]=>
      int(2613)
      ["value"]=>
      float(0.0006269635)
    }
    [377]=>
    array(2) {
      ["index"]=>
      int(2614)
      ["value"]=>
      float(0.10325926)
    }
    [378]=>
    array(2) {
      ["index"]=>
      int(2616)
      ["value"]=>
      float(0.011022984)
    }
    [379]=>
    array(2) {
      ["index"]=>
      int(2624)
      ["value"]=>
      float(0.004035901)
    }
    [380]=>
    array(2) {
      ["index"]=>
      int(2627)
      ["value"]=>
      float(0.008220054)
    }
    [381]=>
    array(2) {
      ["index"]=>
      int(2628)
      ["value"]=>
      float(0.06333622)
    }
    [382]=>
    array(2) {
      ["index"]=>
      int(2632)
      ["value"]=>
      float(0.15376495)
    }
    [383]=>
    array(2) {
      ["index"]=>
      int(2634)
      ["value"]=>
      float(0.20496984)
    }
    [384]=>
    array(2) {
      ["index"]=>
      int(2637)
      ["value"]=>
      float(0.0025072827)
    }
    [385]=>
    array(2) {
      ["index"]=>
      int(2638)
      ["value"]=>
      float(0.018344855)
    }
    [386]=>
    array(2) {
      ["index"]=>
      int(2640)
      ["value"]=>
      float(0.16951132)
    }
    [387]=>
    array(2) {
      ["index"]=>
      int(2643)
      ["value"]=>
      float(0.047525816)
    }
    [388]=>
    array(2) {
      ["index"]=>
      int(2650)
      ["value"]=>
      float(0.15820558)
    }
    [389]=>
    array(2) {
      ["index"]=>
      int(2651)
      ["value"]=>
      float(0.01792119)
    }
    [390]=>
    array(2) {
      ["index"]=>
      int(2652)
      ["value"]=>
      float(0.062163007)
    }
    [391]=>
    array(2) {
      ["index"]=>
      int(2659)
      ["value"]=>
      float(0.03234058)
    }
    [392]=>
    array(2) {
      ["index"]=>
      int(2660)
      ["value"]=>
      float(0.047860082)
    }
    [393]=>
    array(2) {
      ["index"]=>
      int(2662)
      ["value"]=>
      float(0.0060572387)
    }
    [394]=>
    array(2) {
      ["index"]=>
      int(2663)
      ["value"]=>
      float(0.071617514)
    }
    [395]=>
    array(2) {
      ["index"]=>
      int(2666)
      ["value"]=>
      float(0.06833195)
    }
    [396]=>
    array(2) {
      ["index"]=>
      int(2668)
      ["value"]=>
      float(0.1558613)
    }
    [397]=>
    array(2) {
      ["index"]=>
      int(2669)
      ["value"]=>
      float(0.046314657)
    }
    [398]=>
    array(2) {
      ["index"]=>
      int(2674)
      ["value"]=>
      float(0.039870158)
    }
    [399]=>
    array(2) {
      ["index"]=>
      int(2678)
      ["value"]=>
      float(0.04455719)
    }
    [400]=>
    array(2) {
      ["index"]=>
      int(2679)
      ["value"]=>
      float(0.24838273)
    }
    [401]=>
    array(2) {
      ["index"]=>
      int(2686)
      ["value"]=>
      float(0.114116654)
    }
    [402]=>
    array(2) {
      ["index"]=>
      int(2688)
      ["value"]=>
      float(0.005056213)
    }
    [403]=>
    array(2) {
      ["index"]=>
      int(2689)
      ["value"]=>
      float(0.07652742)
    }
    [404]=>
    array(2) {
      ["index"]=>
      int(2690)
      ["value"]=>
      float(0.02403841)
    }
    [405]=>
    array(2) {
      ["index"]=>
      int(2691)
      ["value"]=>
      float(0.08785334)
    }
    [406]=>
    array(2) {
      ["index"]=>
      int(2695)
      ["value"]=>
      float(0.062715694)
    }
    [407]=>
    array(2) {
      ["index"]=>
      int(2697)
      ["value"]=>
      float(0.18697967)
    }
    [408]=>
    array(2) {
      ["index"]=>
      int(2703)
      ["value"]=>
      float(0.014090341)
    }
    [409]=>
    array(2) {
      ["index"]=>
      int(2705)
      ["value"]=>
      float(0.16607684)
    }
    [410]=>
    array(2) {
      ["index"]=>
      int(2710)
      ["value"]=>
      float(0.09542139)
    }
    [411]=>
    array(2) {
      ["index"]=>
      int(2712)
      ["value"]=>
      float(0.07660791)
    }
    [412]=>
    array(2) {
      ["index"]=>
      int(2713)
      ["value"]=>
      float(0.019354539)
    }
    [413]=>
    array(2) {
      ["index"]=>
      int(2715)
      ["value"]=>
      float(0.020646302)
    }
    [414]=>
    array(2) {
      ["index"]=>
      int(2718)
      ["value"]=>
      float(0.114663474)
    }
    [415]=>
    array(2) {
      ["index"]=>
      int(2729)
      ["value"]=>
      float(0.0062041543)
    }
    [416]=>
    array(2) {
      ["index"]=>
      int(2730)
      ["value"]=>
      float(0.10101486)
    }
    [417]=>
    array(2) {
      ["index"]=>
      int(2731)
      ["value"]=>
      float(0.15894474)
    }
    [418]=>
    array(2) {
      ["index"]=>
      int(2732)
      ["value"]=>
      float(0.085160434)
    }
    [419]=>
    array(2) {
      ["index"]=>
      int(2733)
      ["value"]=>
      float(0.018698145)
    }
    [420]=>
    array(2) {
      ["index"]=>
      int(2736)
      ["value"]=>
      float(0.07257173)
    }
    [421]=>
    array(2) {
      ["index"]=>
      int(2738)
      ["value"]=>
      float(0.005205648)
    }
    [422]=>
    array(2) {
      ["index"]=>
      int(2739)
      ["value"]=>
      float(0.016003845)
    }
    [423]=>
    array(2) {
      ["index"]=>
      int(2740)
      ["value"]=>
      float(0.032777563)
    }
    [424]=>
    array(2) {
      ["index"]=>
      int(2741)
      ["value"]=>
      float(0.084268555)
    }
    [425]=>
    array(2) {
      ["index"]=>
      int(2742)
      ["value"]=>
      float(0.27106467)
    }
    [426]=>
    array(2) {
      ["index"]=>
      int(2749)
      ["value"]=>
      float(0.07963816)
    }
    [427]=>
    array(2) {
      ["index"]=>
      int(2753)
      ["value"]=>
      float(0.011980601)
    }
    [428]=>
    array(2) {
      ["index"]=>
      int(2755)
      ["value"]=>
      float(0.045107156)
    }
    [429]=>
    array(2) {
      ["index"]=>
      int(2757)
      ["value"]=>
      float(0.12273073)
    }
    [430]=>
    array(2) {
      ["index"]=>
      int(2758)
      ["value"]=>
      float(0.19929117)
    }
    [431]=>
    array(2) {
      ["index"]=>
      int(2760)
      ["value"]=>
      float(0.014512695)
    }
    [432]=>
    array(2) {
      ["index"]=>
      int(2770)
      ["value"]=>
      float(0.026040897)
    }
    [433]=>
    array(2) {
      ["index"]=>
      int(2772)
      ["value"]=>
      float(0.008302106)
    }
    [434]=>
    array(2) {
      ["index"]=>
      int(2773)
      ["value"]=>
      float(0.025704484)
    }
    [435]=>
    array(2) {
      ["index"]=>
      int(2775)
      ["value"]=>
      float(0.06251661)
    }
    [436]=>
    array(2) {
      ["index"]=>
      int(2777)
      ["value"]=>
      float(0.020689974)
    }
    [437]=>
    array(2) {
      ["index"]=>
      int(2779)
      ["value"]=>
      float(0.11147028)
    }
    [438]=>
    array(2) {
      ["index"]=>
      int(2784)
      ["value"]=>
      float(0.05035576)
    }
    [439]=>
    array(2) {
      ["index"]=>
      int(2788)
      ["value"]=>
      float(0.022513513)
    }
    [440]=>
    array(2) {
      ["index"]=>
      int(2794)
      ["value"]=>
      float(0.08946425)
    }
    [441]=>
    array(2) {
      ["index"]=>
      int(2796)
      ["value"]=>
      float(0.11197965)
    }
    [442]=>
    array(2) {
      ["index"]=>
      int(2799)
      ["value"]=>
      float(0.078677766)
    }
    [443]=>
    array(2) {
      ["index"]=>
      int(2808)
      ["value"]=>
      float(0.009972039)
    }
    [444]=>
    array(2) {
      ["index"]=>
      int(2810)
      ["value"]=>
      float(0.010835973)
    }
    [445]=>
    array(2) {
      ["index"]=>
      int(2811)
      ["value"]=>
      float(0.07947478)
    }
    [446]=>
    array(2) {
      ["index"]=>
      int(2817)
      ["value"]=>
      float(0.09078215)
    }
    [447]=>
    array(2) {
      ["index"]=>
      int(2819)
      ["value"]=>
      float(0.04989747)
    }
    [448]=>
    array(2) {
      ["index"]=>
      int(2822)
      ["value"]=>
      float(0.045183275)
    }
    [449]=>
    array(2) {
      ["index"]=>
      int(2824)
      ["value"]=>
      float(0.0062863706)
    }
    [450]=>
    array(2) {
      ["index"]=>
      int(2827)
      ["value"]=>
      float(0.06098527)
    }
    [451]=>
    array(2) {
      ["index"]=>
      int(2828)
      ["value"]=>
      float(0.08119178)
    }
    [452]=>
    array(2) {
      ["index"]=>
      int(2833)
      ["value"]=>
      float(0.07437089)
    }
    [453]=>
    array(2) {
      ["index"]=>
      int(2835)
      ["value"]=>
      float(0.01518558)
    }
    [454]=>
    array(2) {
      ["index"]=>
      int(2836)
      ["value"]=>
      float(0.05754974)
    }
    [455]=>
    array(2) {
      ["index"]=>
      int(2838)
      ["value"]=>
      float(0.052989602)
    }
    [456]=>
    array(2) {
      ["index"]=>
      int(2845)
      ["value"]=>
      float(0.04370811)
    }
    [457]=>
    array(2) {
      ["index"]=>
      int(2846)
      ["value"]=>
      float(0.043883026)
    }
    [458]=>
    array(2) {
      ["index"]=>
      int(2848)
      ["value"]=>
      float(0.0032070654)
    }
    [459]=>
    array(2) {
      ["index"]=>
      int(2849)
      ["value"]=>
      float(0.032194454)
    }
    [460]=>
    array(2) {
      ["index"]=>
      int(2852)
      ["value"]=>
      float(0.08374443)
    }
    [461]=>
    array(2) {
      ["index"]=>
      int(2853)
      ["value"]=>
      float(0.17990936)
    }
    [462]=>
    array(2) {
      ["index"]=>
      int(2854)
      ["value"]=>
      float(0.010946462)
    }
    [463]=>
    array(2) {
      ["index"]=>
      int(2859)
      ["value"]=>
      float(0.0040957383)
    }
    [464]=>
    array(2) {
      ["index"]=>
      int(2860)
      ["value"]=>
      float(0.011497664)
    }
    [465]=>
    array(2) {
      ["index"]=>
      int(2862)
      ["value"]=>
      float(0.0033879047)
    }
    [466]=>
    array(2) {
      ["index"]=>
      int(2863)
      ["value"]=>
      float(0.03428621)
    }
    [467]=>
    array(2) {
      ["index"]=>
      int(2865)
      ["value"]=>
      float(0.054614153)
    }
    [468]=>
    array(2) {
      ["index"]=>
      int(2866)
      ["value"]=>
      float(0.031309616)
    }
    [469]=>
    array(2) {
      ["index"]=>
      int(2871)
      ["value"]=>
      float(0.04723965)
    }
    [470]=>
    array(2) {
      ["index"]=>
      int(2873)
      ["value"]=>
      float(0.14012487)
    }
    [471]=>
    array(2) {
      ["index"]=>
      int(2886)
      ["value"]=>
      float(0.14598824)
    }
    [472]=>
    array(2) {
      ["index"]=>
      int(2892)
      ["value"]=>
      float(0.071015425)
    }
    [473]=>
    array(2) {
      ["index"]=>
      int(2896)
      ["value"]=>
      float(0.12615895)
    }
    [474]=>
    array(2) {
      ["index"]=>
      int(2897)
      ["value"]=>
      float(0.010716862)
    }
    [475]=>
    array(2) {
      ["index"]=>
      int(2902)
      ["value"]=>
      float(0.0072795385)
    }
    [476]=>
    array(2) {
      ["index"]=>
      int(2909)
      ["value"]=>
      float(0.019931743)
    }
    [477]=>
    array(2) {
      ["index"]=>
      int(2915)
      ["value"]=>
      float(0.11906512)
    }
    [478]=>
    array(2) {
      ["index"]=>
      int(2916)
      ["value"]=>
      float(0.016522486)
    }
    [479]=>
    array(2) {
      ["index"]=>
      int(2918)
      ["value"]=>
      float(0.0007807544)
    }
    [480]=>
    array(2) {
      ["index"]=>
      int(2923)
      ["value"]=>
      float(0.12754577)
    }
    [481]=>
    array(2) {
      ["index"]=>
      int(2924)
      ["value"]=>
      float(0.052462053)
    }
    [482]=>
    array(2) {
      ["index"]=>
      int(2928)
      ["value"]=>
      float(0.03219676)
    }
    [483]=>
    array(2) {
      ["index"]=>
      int(2929)
      ["value"]=>
      float(0.090985924)
    }
    [484]=>
    array(2) {
      ["index"]=>
      int(2931)
      ["value"]=>
      float(0.0056742076)
    }
    [485]=>
    array(2) {
      ["index"]=>
      int(2935)
      ["value"]=>
      float(0.1409736)
    }
    [486]=>
    array(2) {
      ["index"]=>
      int(2938)
      ["value"]=>
      float(0.073024295)
    }
    [487]=>
    array(2) {
      ["index"]=>
      int(2943)
      ["value"]=>
      float(0.08532934)
    }
    [488]=>
    array(2) {
      ["index"]=>
      int(2944)
      ["value"]=>
      float(0.17937098)
    }
    [489]=>
    array(2) {
      ["index"]=>
      int(2945)
      ["value"]=>
      float(0.0150036905)
    }
    [490]=>
    array(2) {
      ["index"]=>
      int(2946)
      ["value"]=>
      float(0.089406796)
    }
    [491]=>
    array(2) {
      ["index"]=>
      int(2948)
      ["value"]=>
      float(0.02916519)
    }
    [492]=>
    array(2) {
      ["index"]=>
      int(2951)
      ["value"]=>
      float(0.10885238)
    }
    [493]=>
    array(2) {
      ["index"]=>
      int(2952)
      ["value"]=>
      float(0.12770043)
    }
    [494]=>
    array(2) {
      ["index"]=>
      int(2953)
      ["value"]=>
      float(0.025529727)
    }
    [495]=>
    array(2) {
      ["index"]=>
      int(2954)
      ["value"]=>
      float(0.043772236)
    }
    [496]=>
    array(2) {
      ["index"]=>
      int(2958)
      ["value"]=>
      float(0.10144558)
    }
    [497]=>
    array(2) {
      ["index"]=>
      int(2964)
      ["value"]=>
      float(0.05946282)
    }
    [498]=>
    array(2) {
      ["index"]=>
      int(2965)
      ["value"]=>
      float(0.043791633)
    }
    [499]=>
    array(2) {
      ["index"]=>
      int(2974)
      ["value"]=>
      float(0.08173053)
    }
    [500]=>
    array(2) {
      ["index"]=>
      int(2980)
      ["value"]=>
      float(0.1412678)
    }
    [501]=>
    array(2) {
      ["index"]=>
      int(2983)
      ["value"]=>
      float(0.022303108)
    }
    [502]=>
    array(2) {
      ["index"]=>
      int(2990)
      ["value"]=>
      float(0.024630481)
    }
    [503]=>
    array(2) {
      ["index"]=>
      int(2998)
      ["value"]=>
      float(0.08993755)
    }
    [504]=>
    array(2) {
      ["index"]=>
      int(3000)
      ["value"]=>
      float(0.0134357745)
    }
    [505]=>
    array(2) {
      ["index"]=>
      int(3002)
      ["value"]=>
      float(0.08741903)
    }
    [506]=>
    array(2) {
      ["index"]=>
      int(3003)
      ["value"]=>
      float(0.015797699)
    }
    [507]=>
    array(2) {
      ["index"]=>
      int(3006)
      ["value"]=>
      float(0.04181275)
    }
    [508]=>
    array(2) {
      ["index"]=>
      int(3007)
      ["value"]=>
      float(0.0012790126)
    }
    [509]=>
    array(2) {
      ["index"]=>
      int(3010)
      ["value"]=>
      float(0.060211316)
    }
    [510]=>
    array(2) {
      ["index"]=>
      int(3011)
      ["value"]=>
      float(0.0619219)
    }
    [511]=>
    array(2) {
      ["index"]=>
      int(3013)
      ["value"]=>
      float(0.036143787)
    }
    [512]=>
    array(2) {
      ["index"]=>
      int(3015)
      ["value"]=>
      float(0.047081925)
    }
    [513]=>
    array(2) {
      ["index"]=>
      int(3016)
      ["value"]=>
      float(0.0126972115)
    }
    [514]=>
    array(2) {
      ["index"]=>
      int(3017)
      ["value"]=>
      float(0.025028761)
    }
    [515]=>
    array(2) {
      ["index"]=>
      int(3019)
      ["value"]=>
      float(0.018322501)
    }
    [516]=>
    array(2) {
      ["index"]=>
      int(3020)
      ["value"]=>
      float(0.010207001)
    }
    [517]=>
    array(2) {
      ["index"]=>
      int(3021)
      ["value"]=>
      float(0.076761715)
    }
    [518]=>
    array(2) {
      ["index"]=>
      int(3034)
      ["value"]=>
      float(0.055527672)
    }
    [519]=>
    array(2) {
      ["index"]=>
      int(3035)
      ["value"]=>
      float(0.0045801257)
    }
    [520]=>
    array(2) {
      ["index"]=>
      int(3036)
      ["value"]=>
      float(0.078980744)
    }
    [521]=>
    array(2) {
      ["index"]=>
      int(3037)
      ["value"]=>
      float(0.021437244)
    }
    [522]=>
    array(2) {
      ["index"]=>
      int(3039)
      ["value"]=>
      float(0.043562263)
    }
    [523]=>
    array(2) {
      ["index"]=>
      int(3042)
      ["value"]=>
      float(0.08761639)
    }
    [524]=>
    array(2) {
      ["index"]=>
      int(3043)
      ["value"]=>
      float(0.034189906)
    }
    [525]=>
    array(2) {
      ["index"]=>
      int(3058)
      ["value"]=>
      float(0.20434946)
    }
    [526]=>
    array(2) {
      ["index"]=>
      int(3059)
      ["value"]=>
      float(0.13298398)
    }
    [527]=>
    array(2) {
      ["index"]=>
      int(3075)
      ["value"]=>
      float(0.044311687)
    }
    [528]=>
    array(2) {
      ["index"]=>
      int(3088)
      ["value"]=>
      float(0.008541007)
    }
    [529]=>
    array(2) {
      ["index"]=>
      int(3089)
      ["value"]=>
      float(0.005687839)
    }
    [530]=>
    array(2) {
      ["index"]=>
      int(3091)
      ["value"]=>
      float(0.044361636)
    }
    [531]=>
    array(2) {
      ["index"]=>
      int(3094)
      ["value"]=>
      float(0.15106149)
    }
    [532]=>
    array(2) {
      ["index"]=>
      int(3095)
      ["value"]=>
      float(0.033475395)
    }
    [533]=>
    array(2) {
      ["index"]=>
      int(3098)
      ["value"]=>
      float(0.016453302)
    }
    [534]=>
    array(2) {
      ["index"]=>
      int(3104)
      ["value"]=>
      float(0.014110087)
    }
    [535]=>
    array(2) {
      ["index"]=>
      int(3116)
      ["value"]=>
      float(0.029299606)
    }
    [536]=>
    array(2) {
      ["index"]=>
      int(3117)
      ["value"]=>
      float(0.03618713)
    }
    [537]=>
    array(2) {
      ["index"]=>
      int(3119)
      ["value"]=>
      float(0.017797884)
    }
    [538]=>
    array(2) {
      ["index"]=>
      int(3123)
      ["value"]=>
      float(0.1641131)
    }
    [539]=>
    array(2) {
      ["index"]=>
      int(3125)
      ["value"]=>
      float(0.01891855)
    }
    [540]=>
    array(2) {
      ["index"]=>
      int(3126)
      ["value"]=>
      float(0.01786475)
    }
    [541]=>
    array(2) {
      ["index"]=>
      int(3128)
      ["value"]=>
      float(0.18241826)
    }
    [542]=>
    array(2) {
      ["index"]=>
      int(3131)
      ["value"]=>
      float(0.028330512)
    }
    [543]=>
    array(2) {
      ["index"]=>
      int(3132)
      ["value"]=>
      float(0.020011203)
    }
    [544]=>
    array(2) {
      ["index"]=>
      int(3136)
      ["value"]=>
      float(0.017475205)
    }
    [545]=>
    array(2) {
      ["index"]=>
      int(3137)
      ["value"]=>
      float(0.0798561)
    }
    [546]=>
    array(2) {
      ["index"]=>
      int(3138)
      ["value"]=>
      float(0.033598974)
    }
    [547]=>
    array(2) {
      ["index"]=>
      int(3140)
      ["value"]=>
      float(0.01367604)
    }
    [548]=>
    array(2) {
      ["index"]=>
      int(3143)
      ["value"]=>
      float(0.030393932)
    }
    [549]=>
    array(2) {
      ["index"]=>
      int(3145)
      ["value"]=>
      float(0.07913076)
    }
    [550]=>
    array(2) {
      ["index"]=>
      int(3147)
      ["value"]=>
      float(0.030525869)
    }
    [551]=>
    array(2) {
      ["index"]=>
      int(3148)
      ["value"]=>
      float(0.015008623)
    }
    [552]=>
    array(2) {
      ["index"]=>
      int(3149)
      ["value"]=>
      float(0.07977069)
    }
    [553]=>
    array(2) {
      ["index"]=>
      int(3151)
      ["value"]=>
      float(0.0712105)
    }
    [554]=>
    array(2) {
      ["index"]=>
      int(3153)
      ["value"]=>
      float(0.08957979)
    }
    [555]=>
    array(2) {
      ["index"]=>
      int(3158)
      ["value"]=>
      float(0.03122019)
    }
    [556]=>
    array(2) {
      ["index"]=>
      int(3159)
      ["value"]=>
      float(0.038531087)
    }
    [557]=>
    array(2) {
      ["index"]=>
      int(3161)
      ["value"]=>
      float(0.007624454)
    }
    [558]=>
    array(2) {
      ["index"]=>
      int(3162)
      ["value"]=>
      float(0.104953855)
    }
    [559]=>
    array(2) {
      ["index"]=>
      int(3177)
      ["value"]=>
      float(0.12012664)
    }
    [560]=>
    array(2) {
      ["index"]=>
      int(3189)
      ["value"]=>
      float(0.009113028)
    }
    [561]=>
    array(2) {
      ["index"]=>
      int(3191)
      ["value"]=>
      float(0.11183139)
    }
    [562]=>
    array(2) {
      ["index"]=>
      int(3203)
      ["value"]=>
      float(0.05261147)
    }
    [563]=>
    array(2) {
      ["index"]=>
      int(3205)
      ["value"]=>
      float(0.058978684)
    }
    [564]=>
    array(2) {
      ["index"]=>
      int(3207)
      ["value"]=>
      float(0.013920479)
    }
    [565]=>
    array(2) {
      ["index"]=>
      int(3208)
      ["value"]=>
      float(0.039865576)
    }
    [566]=>
    array(2) {
      ["index"]=>
      int(3212)
      ["value"]=>
      float(0.009350791)
    }
    [567]=>
    array(2) {
      ["index"]=>
      int(3223)
      ["value"]=>
      float(0.080547035)
    }
    [568]=>
    array(2) {
      ["index"]=>
      int(3229)
      ["value"]=>
      float(0.14357339)
    }
    [569]=>
    array(2) {
      ["index"]=>
      int(3231)
      ["value"]=>
      float(0.14441259)
    }
    [570]=>
    array(2) {
      ["index"]=>
      int(3242)
      ["value"]=>
      float(0.031538118)
    }
    [571]=>
    array(2) {
      ["index"]=>
      int(3249)
      ["value"]=>
      float(0.03403276)
    }
    [572]=>
    array(2) {
      ["index"]=>
      int(3255)
      ["value"]=>
      float(0.040439077)
    }
    [573]=>
    array(2) {
      ["index"]=>
      int(3256)
      ["value"]=>
      float(0.07969903)
    }
    [574]=>
    array(2) {
      ["index"]=>
      int(3257)
      ["value"]=>
      float(0.051700264)
    }
    [575]=>
    array(2) {
      ["index"]=>
      int(3259)
      ["value"]=>
      float(0.0005413021)
    }
    [576]=>
    array(2) {
      ["index"]=>
      int(3260)
      ["value"]=>
      float(0.04438376)
    }
    [577]=>
    array(2) {
      ["index"]=>
      int(3262)
      ["value"]=>
      float(0.02081701)
    }
    [578]=>
    array(2) {
      ["index"]=>
      int(3264)
      ["value"]=>
      float(0.07834251)
    }
    [579]=>
    array(2) {
      ["index"]=>
      int(3267)
      ["value"]=>
      float(0.004052404)
    }
    [580]=>
    array(2) {
      ["index"]=>
      int(3268)
      ["value"]=>
      float(0.0710373)
    }
    [581]=>
    array(2) {
      ["index"]=>
      int(3269)
      ["value"]=>
      float(0.04666844)
    }
    [582]=>
    array(2) {
      ["index"]=>
      int(3277)
      ["value"]=>
      float(0.011287168)
    }
    [583]=>
    array(2) {
      ["index"]=>
      int(3279)
      ["value"]=>
      float(0.026853813)
    }
    [584]=>
    array(2) {
      ["index"]=>
      int(3280)
      ["value"]=>
      float(0.11542904)
    }
    [585]=>
    array(2) {
      ["index"]=>
      int(3282)
      ["value"]=>
      float(0.008105717)
    }
    [586]=>
    array(2) {
      ["index"]=>
      int(3286)
      ["value"]=>
      float(0.027335888)
    }
    [587]=>
    array(2) {
      ["index"]=>
      int(3287)
      ["value"]=>
      float(0.041663088)
    }
    [588]=>
    array(2) {
      ["index"]=>
      int(3289)
      ["value"]=>
      float(0.08463316)
    }
    [589]=>
    array(2) {
      ["index"]=>
      int(3290)
      ["value"]=>
      float(0.058414932)
    }
    [590]=>
    array(2) {
      ["index"]=>
      int(3292)
      ["value"]=>
      float(0.080324955)
    }
    [591]=>
    array(2) {
      ["index"]=>
      int(3302)
      ["value"]=>
      float(0.041134104)
    }
    [592]=>
    array(2) {
      ["index"]=>
      int(3303)
      ["value"]=>
      float(0.009887764)
    }
    [593]=>
    array(2) {
      ["index"]=>
      int(3306)
      ["value"]=>
      float(0.046160653)
    }
    [594]=>
    array(2) {
      ["index"]=>
      int(3317)
      ["value"]=>
      float(0.021662297)
    }
    [595]=>
    array(2) {
      ["index"]=>
      int(3318)
      ["value"]=>
      float(0.030189922)
    }
    [596]=>
    array(2) {
      ["index"]=>
      int(3319)
      ["value"]=>
      float(0.050021984)
    }
    [597]=>
    array(2) {
      ["index"]=>
      int(3324)
      ["value"]=>
      float(0.0034617994)
    }
    [598]=>
    array(2) {
      ["index"]=>
      int(3327)
      ["value"]=>
      float(0.10921465)
    }
    [599]=>
    array(2) {
      ["index"]=>
      int(3329)
      ["value"]=>
      float(0.026780002)
    }
    [600]=>
    array(2) {
      ["index"]=>
      int(3334)
      ["value"]=>
      float(0.011517227)
    }
    [601]=>
    array(2) {
      ["index"]=>
      int(3340)
      ["value"]=>
      float(0.10692414)
    }
    [602]=>
    array(2) {
      ["index"]=>
      int(3345)
      ["value"]=>
      float(0.050835587)
    }
    [603]=>
    array(2) {
      ["index"]=>
      int(3348)
      ["value"]=>
      float(0.14405717)
    }
    [604]=>
    array(2) {
      ["index"]=>
      int(3351)
      ["value"]=>
      float(0.0011770948)
    }
    [605]=>
    array(2) {
      ["index"]=>
      int(3356)
      ["value"]=>
      float(0.002028909)
    }
    [606]=>
    array(2) {
      ["index"]=>
      int(3358)
      ["value"]=>
      float(0.018773373)
    }
    [607]=>
    array(2) {
      ["index"]=>
      int(3366)
      ["value"]=>
      float(0.06793351)
    }
    [608]=>
    array(2) {
      ["index"]=>
      int(3367)
      ["value"]=>
      float(0.067991205)
    }
    [609]=>
    array(2) {
      ["index"]=>
      int(3371)
      ["value"]=>
      float(0.035585184)
    }
    [610]=>
    array(2) {
      ["index"]=>
      int(3375)
      ["value"]=>
      float(0.014424102)
    }
    [611]=>
    array(2) {
      ["index"]=>
      int(3379)
      ["value"]=>
      float(0.036797106)
    }
    [612]=>
    array(2) {
      ["index"]=>
      int(3384)
      ["value"]=>
      float(0.0526316)
    }
    [613]=>
    array(2) {
      ["index"]=>
      int(3393)
      ["value"]=>
      float(0.02717499)
    }
    [614]=>
    array(2) {
      ["index"]=>
      int(3394)
      ["value"]=>
      float(0.25429615)
    }
    [615]=>
    array(2) {
      ["index"]=>
      int(3400)
      ["value"]=>
      float(0.01606344)
    }
    [616]=>
    array(2) {
      ["index"]=>
      int(3401)
      ["value"]=>
      float(0.07370125)
    }
    [617]=>
    array(2) {
      ["index"]=>
      int(3405)
      ["value"]=>
      float(0.0064646406)
    }
    [618]=>
    array(2) {
      ["index"]=>
      int(3406)
      ["value"]=>
      float(0.004483172)
    }
    [619]=>
    array(2) {
      ["index"]=>
      int(3409)
      ["value"]=>
      float(0.07191243)
    }
    [620]=>
    array(2) {
      ["index"]=>
      int(3413)
      ["value"]=>
      float(0.051122535)
    }
    [621]=>
    array(2) {
      ["index"]=>
      int(3415)
      ["value"]=>
      float(0.0040985877)
    }
    [622]=>
    array(2) {
      ["index"]=>
      int(3417)
      ["value"]=>
      float(0.12228809)
    }
    [623]=>
    array(2) {
      ["index"]=>
      int(3418)
      ["value"]=>
      float(0.033086695)
    }
    [624]=>
    array(2) {
      ["index"]=>
      int(3424)
      ["value"]=>
      float(0.012620582)
    }
    [625]=>
    array(2) {
      ["index"]=>
      int(3425)
      ["value"]=>
      float(0.06479201)
    }
    [626]=>
    array(2) {
      ["index"]=>
      int(3433)
      ["value"]=>
      float(0.019466313)
    }
    [627]=>
    array(2) {
      ["index"]=>
      int(3436)
      ["value"]=>
      float(0.026655579)
    }
    [628]=>
    array(2) {
      ["index"]=>
      int(3445)
      ["value"]=>
      float(0.077431075)
    }
    [629]=>
    array(2) {
      ["index"]=>
      int(3446)
      ["value"]=>
      float(0.004605994)
    }
    [630]=>
    array(2) {
      ["index"]=>
      int(3449)
      ["value"]=>
      float(0.047463972)
    }
    [631]=>
    array(2) {
      ["index"]=>
      int(3459)
      ["value"]=>
      float(0.1476477)
    }
    [632]=>
    array(2) {
      ["index"]=>
      int(3460)
      ["value"]=>
      float(0.10110882)
    }
    [633]=>
    array(2) {
      ["index"]=>
      int(3463)
      ["value"]=>
      float(0.07488933)
    }
    [634]=>
    array(2) {
      ["index"]=>
      int(3465)
      ["value"]=>
      float(0.06089386)
    }
    [635]=>
    array(2) {
      ["index"]=>
      int(3467)
      ["value"]=>
      float(0.005851757)
    }
    [636]=>
    array(2) {
      ["index"]=>
      int(3481)
      ["value"]=>
      float(0.15254371)
    }
    [637]=>
    array(2) {
      ["index"]=>
      int(3482)
      ["value"]=>
      float(0.019551186)
    }
    [638]=>
    array(2) {
      ["index"]=>
      int(3488)
      ["value"]=>
      float(0.06035565)
    }
    [639]=>
    array(2) {
      ["index"]=>
      int(3490)
      ["value"]=>
      float(0.040897712)
    }
    [640]=>
    array(2) {
      ["index"]=>
      int(3493)
      ["value"]=>
      float(0.07663475)
    }
    [641]=>
    array(2) {
      ["index"]=>
      int(3503)
      ["value"]=>
      float(0.009864628)
    }
    [642]=>
    array(2) {
      ["index"]=>
      int(3506)
      ["value"]=>
      float(0.00426241)
    }
    [643]=>
    array(2) {
      ["index"]=>
      int(3509)
      ["value"]=>
      float(0.053795036)
    }
    [644]=>
    array(2) {
      ["index"]=>
      int(3513)
      ["value"]=>
      float(0.13166718)
    }
    [645]=>
    array(2) {
      ["index"]=>
      int(3514)
      ["value"]=>
      float(0.18357569)
    }
    [646]=>
    array(2) {
      ["index"]=>
      int(3516)
      ["value"]=>
      float(0.003203144)
    }
    [647]=>
    array(2) {
      ["index"]=>
      int(3517)
      ["value"]=>
      float(0.030949662)
    }
    [648]=>
    array(2) {
      ["index"]=>
      int(3519)
      ["value"]=>
      float(0.010550437)
    }
    [649]=>
    array(2) {
      ["index"]=>
      int(3526)
      ["value"]=>
      float(0.030569576)
    }
    [650]=>
    array(2) {
      ["index"]=>
      int(3540)
      ["value"]=>
      float(0.050198067)
    }
    [651]=>
    array(2) {
      ["index"]=>
      int(3542)
      ["value"]=>
      float(0.0031701094)
    }
    [652]=>
    array(2) {
      ["index"]=>
      int(3545)
      ["value"]=>
      float(0.04772916)
    }
    [653]=>
    array(2) {
      ["index"]=>
      int(3549)
      ["value"]=>
      float(0.12320605)
    }
    [654]=>
    array(2) {
      ["index"]=>
      int(3556)
      ["value"]=>
      float(0.053102992)
    }
    [655]=>
    array(2) {
      ["index"]=>
      int(3559)
      ["value"]=>
      float(0.025773378)
    }
    [656]=>
    array(2) {
      ["index"]=>
      int(3572)
      ["value"]=>
      float(0.00020144341)
    }
    [657]=>
    array(2) {
      ["index"]=>
      int(3573)
      ["value"]=>
      float(0.09450369)
    }
    [658]=>
    array(2) {
      ["index"]=>
      int(3574)
      ["value"]=>
      float(0.12510286)
    }
    [659]=>
    array(2) {
      ["index"]=>
      int(3575)
      ["value"]=>
      float(0.06630894)
    }
    [660]=>
    array(2) {
      ["index"]=>
      int(3583)
      ["value"]=>
      float(0.009358113)
    }
    [661]=>
    array(2) {
      ["index"]=>
      int(3586)
      ["value"]=>
      float(0.03568147)
    }
    [662]=>
    array(2) {
      ["index"]=>
      int(3594)
      ["value"]=>
      float(0.01850753)
    }
    [663]=>
    array(2) {
      ["index"]=>
      int(3596)
      ["value"]=>
      float(0.05738913)
    }
    [664]=>
    array(2) {
      ["index"]=>
      int(3597)
      ["value"]=>
      float(0.01638564)
    }
    [665]=>
    array(2) {
      ["index"]=>
      int(3602)
      ["value"]=>
      float(0.017743545)
    }
    [666]=>
    array(2) {
      ["index"]=>
      int(3604)
      ["value"]=>
      float(0.010392596)
    }
    [667]=>
    array(2) {
      ["index"]=>
      int(3609)
      ["value"]=>
      float(0.06320328)
    }
    [668]=>
    array(2) {
      ["index"]=>
      int(3616)
      ["value"]=>
      float(0.07514613)
    }
    [669]=>
    array(2) {
      ["index"]=>
      int(3618)
      ["value"]=>
      float(0.022495214)
    }
    [670]=>
    array(2) {
      ["index"]=>
      int(3622)
      ["value"]=>
      float(0.004429292)
    }
    [671]=>
    array(2) {
      ["index"]=>
      int(3623)
      ["value"]=>
      float(0.09302191)
    }
    [672]=>
    array(2) {
      ["index"]=>
      int(3626)
      ["value"]=>
      float(0.12979168)
    }
    [673]=>
    array(2) {
      ["index"]=>
      int(3627)
      ["value"]=>
      float(0.011754183)
    }
    [674]=>
    array(2) {
      ["index"]=>
      int(3635)
      ["value"]=>
      float(0.036528196)
    }
    [675]=>
    array(2) {
      ["index"]=>
      int(3637)
      ["value"]=>
      float(0.061819144)
    }
    [676]=>
    array(2) {
      ["index"]=>
      int(3639)
      ["value"]=>
      float(0.06009929)
    }
    [677]=>
    array(2) {
      ["index"]=>
      int(3642)
      ["value"]=>
      float(0.024328616)
    }
    [678]=>
    array(2) {
      ["index"]=>
      int(3644)
      ["value"]=>
      float(0.0088815885)
    }
    [679]=>
    array(2) {
      ["index"]=>
      int(3647)
      ["value"]=>
      float(0.07558448)
    }
    [680]=>
    array(2) {
      ["index"]=>
      int(3648)
      ["value"]=>
      float(0.031091118)
    }
    [681]=>
    array(2) {
      ["index"]=>
      int(3653)
      ["value"]=>
      float(0.017752446)
    }
    [682]=>
    array(2) {
      ["index"]=>
      int(3658)
      ["value"]=>
      float(0.0026507976)
    }
    [683]=>
    array(2) {
      ["index"]=>
      int(3659)
      ["value"]=>
      float(0.019555276)
    }
    [684]=>
    array(2) {
      ["index"]=>
      int(3665)
      ["value"]=>
      float(0.101959646)
    }
    [685]=>
    array(2) {
      ["index"]=>
      int(3667)
      ["value"]=>
      float(0.029901529)
    }
    [686]=>
    array(2) {
      ["index"]=>
      int(3668)
      ["value"]=>
      float(0.04514476)
    }
    [687]=>
    array(2) {
      ["index"]=>
      int(3671)
      ["value"]=>
      float(0.10777346)
    }
    [688]=>
    array(2) {
      ["index"]=>
      int(3676)
      ["value"]=>
      float(0.0117097655)
    }
    [689]=>
    array(2) {
      ["index"]=>
      int(3677)
      ["value"]=>
      float(0.14694409)
    }
    [690]=>
    array(2) {
      ["index"]=>
      int(3684)
      ["value"]=>
      float(0.017956316)
    }
    [691]=>
    array(2) {
      ["index"]=>
      int(3686)
      ["value"]=>
      float(0.0402781)
    }
    [692]=>
    array(2) {
      ["index"]=>
      int(3698)
      ["value"]=>
      float(0.043265373)
    }
    [693]=>
    array(2) {
      ["index"]=>
      int(3707)
      ["value"]=>
      float(0.108823836)
    }
    [694]=>
    array(2) {
      ["index"]=>
      int(3715)
      ["value"]=>
      float(0.0048149354)
    }
    [695]=>
    array(2) {
      ["index"]=>
      int(3727)
      ["value"]=>
      float(0.051638115)
    }
    [696]=>
    array(2) {
      ["index"]=>
      int(3729)
      ["value"]=>
      float(0.026002567)
    }
    [697]=>
    array(2) {
      ["index"]=>
      int(3731)
      ["value"]=>
      float(0.04017378)
    }
    [698]=>
    array(2) {
      ["index"]=>
      int(3737)
      ["value"]=>
      float(0.004874964)
    }
    [699]=>
    array(2) {
      ["index"]=>
      int(3748)
      ["value"]=>
      float(0.07033076)
    }
    [700]=>
    array(2) {
      ["index"]=>
      int(3751)
      ["value"]=>
      float(0.08351571)
    }
    [701]=>
    array(2) {
      ["index"]=>
      int(3752)
      ["value"]=>
      float(0.14240818)
    }
    [702]=>
    array(2) {
      ["index"]=>
      int(3756)
      ["value"]=>
      float(0.0055115647)
    }
    [703]=>
    array(2) {
      ["index"]=>
      int(3772)
      ["value"]=>
      float(0.049135312)
    }
    [704]=>
    array(2) {
      ["index"]=>
      int(3778)
      ["value"]=>
      float(0.09170891)
    }
    [705]=>
    array(2) {
      ["index"]=>
      int(3784)
      ["value"]=>
      float(0.013062972)
    }
    [706]=>
    array(2) {
      ["index"]=>
      int(3786)
      ["value"]=>
      float(0.042824496)
    }
    [707]=>
    array(2) {
      ["index"]=>
      int(3793)
      ["value"]=>
      float(0.04714106)
    }
    [708]=>
    array(2) {
      ["index"]=>
      int(3796)
      ["value"]=>
      float(0.090624936)
    }
    [709]=>
    array(2) {
      ["index"]=>
      int(3800)
      ["value"]=>
      float(0.004566242)
    }
    [710]=>
    array(2) {
      ["index"]=>
      int(3801)
      ["value"]=>
      float(0.077915184)
    }
    [711]=>
    array(2) {
      ["index"]=>
      int(3802)
      ["value"]=>
      float(0.12930262)
    }
    [712]=>
    array(2) {
      ["index"]=>
      int(3804)
      ["value"]=>
      float(0.05101572)
    }
    [713]=>
    array(2) {
      ["index"]=>
      int(3806)
      ["value"]=>
      float(0.19049181)
    }
    [714]=>
    array(2) {
      ["index"]=>
      int(3808)
      ["value"]=>
      float(0.0101173185)
    }
    [715]=>
    array(2) {
      ["index"]=>
      int(3818)
      ["value"]=>
      float(0.028064417)
    }
    [716]=>
    array(2) {
      ["index"]=>
      int(3844)
      ["value"]=>
      float(0.023156693)
    }
    [717]=>
    array(2) {
      ["index"]=>
      int(3847)
      ["value"]=>
      float(0.0015644704)
    }
    [718]=>
    array(2) {
      ["index"]=>
      int(3848)
      ["value"]=>
      float(0.07131596)
    }
    [719]=>
    array(2) {
      ["index"]=>
      int(3853)
      ["value"]=>
      float(0.061232656)
    }
    [720]=>
    array(2) {
      ["index"]=>
      int(3860)
      ["value"]=>
      float(0.04402255)
    }
    [721]=>
    array(2) {
      ["index"]=>
      int(3863)
      ["value"]=>
      float(0.10713118)
    }
    [722]=>
    array(2) {
      ["index"]=>
      int(3868)
      ["value"]=>
      float(0.0063103)
    }
    [723]=>
    array(2) {
      ["index"]=>
      int(3869)
      ["value"]=>
      float(0.05084635)
    }
    [724]=>
    array(2) {
      ["index"]=>
      int(3872)
      ["value"]=>
      float(0.0041381214)
    }
    [725]=>
    array(2) {
      ["index"]=>
      int(3884)
      ["value"]=>
      float(0.025302988)
    }
    [726]=>
    array(2) {
      ["index"]=>
      int(3886)
      ["value"]=>
      float(0.12538274)
    }
    [727]=>
    array(2) {
      ["index"]=>
      int(3891)
      ["value"]=>
      float(0.00048554075)
    }
    [728]=>
    array(2) {
      ["index"]=>
      int(3893)
      ["value"]=>
      float(0.026185602)
    }
    [729]=>
    array(2) {
      ["index"]=>
      int(3896)
      ["value"]=>
      float(0.047296844)
    }
    [730]=>
    array(2) {
      ["index"]=>
      int(3899)
      ["value"]=>
      float(0.03499542)
    }
    [731]=>
    array(2) {
      ["index"]=>
      int(3907)
      ["value"]=>
      float(0.1634377)
    }
    [732]=>
    array(2) {
      ["index"]=>
      int(3926)
      ["value"]=>
      float(0.014085286)
    }
    [733]=>
    array(2) {
      ["index"]=>
      int(3930)
      ["value"]=>
      float(0.10137901)
    }
    [734]=>
    array(2) {
      ["index"]=>
      int(3931)
      ["value"]=>
      float(0.089212954)
    }
    [735]=>
    array(2) {
      ["index"]=>
      int(3932)
      ["value"]=>
      float(0.03146685)
    }
    [736]=>
    array(2) {
      ["index"]=>
      int(3945)
      ["value"]=>
      float(0.05225944)
    }
    [737]=>
    array(2) {
      ["index"]=>
      int(3946)
      ["value"]=>
      float(0.050051577)
    }
    [738]=>
    array(2) {
      ["index"]=>
      int(3948)
      ["value"]=>
      float(0.021713857)
    }
    [739]=>
    array(2) {
      ["index"]=>
      int(3950)
      ["value"]=>
      float(0.02247365)
    }
    [740]=>
    array(2) {
      ["index"]=>
      int(3956)
      ["value"]=>
      float(0.07524974)
    }
    [741]=>
    array(2) {
      ["index"]=>
      int(3964)
      ["value"]=>
      float(0.0563963)
    }
    [742]=>
    array(2) {
      ["index"]=>
      int(3967)
      ["value"]=>
      float(0.0026920529)
    }
    [743]=>
    array(2) {
      ["index"]=>
      int(3968)
      ["value"]=>
      float(0.08496576)
    }
    [744]=>
    array(2) {
      ["index"]=>
      int(3972)
      ["value"]=>
      float(0.06152594)
    }
    [745]=>
    array(2) {
      ["index"]=>
      int(3975)
      ["value"]=>
      float(0.019555861)
    }
    [746]=>
    array(2) {
      ["index"]=>
      int(3976)
      ["value"]=>
      float(0.040120415)
    }
    [747]=>
    array(2) {
      ["index"]=>
      int(3980)
      ["value"]=>
      float(0.017832313)
    }
    [748]=>
    array(2) {
      ["index"]=>
      int(3981)
      ["value"]=>
      float(0.052481964)
    }
    [749]=>
    array(2) {
      ["index"]=>
      int(3986)
      ["value"]=>
      float(0.025117466)
    }
    [750]=>
    array(2) {
      ["index"]=>
      int(3996)
      ["value"]=>
      float(0.0046013664)
    }
    [751]=>
    array(2) {
      ["index"]=>
      int(3997)
      ["value"]=>
      float(0.016799405)
    }
    [752]=>
    array(2) {
      ["index"]=>
      int(4003)
      ["value"]=>
      float(0.04891908)
    }
    [753]=>
    array(2) {
      ["index"]=>
      int(4004)
      ["value"]=>
      float(0.12305775)
    }
    [754]=>
    array(2) {
      ["index"]=>
      int(4005)
      ["value"]=>
      float(0.019696133)
    }
    [755]=>
    array(2) {
      ["index"]=>
      int(4009)
      ["value"]=>
      float(0.0013333011)
    }
    [756]=>
    array(2) {
      ["index"]=>
      int(4019)
      ["value"]=>
      float(0.006289569)
    }
    [757]=>
    array(2) {
      ["index"]=>
      int(4022)
      ["value"]=>
      float(0.0053468794)
    }
    [758]=>
    array(2) {
      ["index"]=>
      int(4026)
      ["value"]=>
      float(0.11195098)
    }
    [759]=>
    array(2) {
      ["index"]=>
      int(4030)
      ["value"]=>
      float(0.08052933)
    }
    [760]=>
    array(2) {
      ["index"]=>
      int(4032)
      ["value"]=>
      float(0.013625945)
    }
    [761]=>
    array(2) {
      ["index"]=>
      int(4033)
      ["value"]=>
      float(0.018596115)
    }
    [762]=>
    array(2) {
      ["index"]=>
      int(4044)
      ["value"]=>
      float(0.00513461)
    }
    [763]=>
    array(2) {
      ["index"]=>
      int(4049)
      ["value"]=>
      float(0.0115726115)
    }
    [764]=>
    array(2) {
      ["index"]=>
      int(4053)
      ["value"]=>
      float(0.053680822)
    }
    [765]=>
    array(2) {
      ["index"]=>
      int(4063)
      ["value"]=>
      float(0.00068509945)
    }
    [766]=>
    array(2) {
      ["index"]=>
      int(4086)
      ["value"]=>
      float(0.0061522624)
    }
    [767]=>
    array(2) {
      ["index"]=>
      int(4108)
      ["value"]=>
      float(0.011799306)
    }
    [768]=>
    array(2) {
      ["index"]=>
      int(4117)
      ["value"]=>
      float(0.04925867)
    }
    [769]=>
    array(2) {
      ["index"]=>
      int(4144)
      ["value"]=>
      float(0.06159342)
    }
    [770]=>
    array(2) {
      ["index"]=>
      int(4153)
      ["value"]=>
      float(0.012391484)
    }
    [771]=>
    array(2) {
      ["index"]=>
      int(4169)
      ["value"]=>
      float(0.061859373)
    }
    [772]=>
    array(2) {
      ["index"]=>
      int(4171)
      ["value"]=>
      float(0.06961382)
    }
    [773]=>
    array(2) {
      ["index"]=>
      int(4176)
      ["value"]=>
      float(0.02481435)
    }
    [774]=>
    array(2) {
      ["index"]=>
      int(4180)
      ["value"]=>
      float(0.09759878)
    }
    [775]=>
    array(2) {
      ["index"]=>
      int(4190)
      ["value"]=>
      float(0.10474368)
    }
    [776]=>
    array(2) {
      ["index"]=>
      int(4195)
      ["value"]=>
      float(0.044787016)
    }
    [777]=>
    array(2) {
      ["index"]=>
      int(4204)
      ["value"]=>
      float(0.09178635)
    }
    [778]=>
    array(2) {
      ["index"]=>
      int(4212)
      ["value"]=>
      float(0.026133344)
    }
    [779]=>
    array(2) {
      ["index"]=>
      int(4215)
      ["value"]=>
      float(0.03781669)
    }
    [780]=>
    array(2) {
      ["index"]=>
      int(4221)
      ["value"]=>
      float(0.058155935)
    }
    [781]=>
    array(2) {
      ["index"]=>
      int(4226)
      ["value"]=>
      float(0.07544841)
    }
    [782]=>
    array(2) {
      ["index"]=>
      int(4231)
      ["value"]=>
      float(0.03101473)
    }
    [783]=>
    array(2) {
      ["index"]=>
      int(4241)
      ["value"]=>
      float(0.06541025)
    }
    [784]=>
    array(2) {
      ["index"]=>
      int(4242)
      ["value"]=>
      float(0.020538162)
    }
    [785]=>
    array(2) {
      ["index"]=>
      int(4245)
      ["value"]=>
      float(0.04415042)
    }
    [786]=>
    array(2) {
      ["index"]=>
      int(4257)
      ["value"]=>
      float(0.014943562)
    }
    [787]=>
    array(2) {
      ["index"]=>
      int(4264)
      ["value"]=>
      float(0.06963951)
    }
    [788]=>
    array(2) {
      ["index"]=>
      int(4269)
      ["value"]=>
      float(0.0037195561)
    }
    [789]=>
    array(2) {
      ["index"]=>
      int(4272)
      ["value"]=>
      float(0.058405034)
    }
    [790]=>
    array(2) {
      ["index"]=>
      int(4276)
      ["value"]=>
      float(0.0067455433)
    }
    [791]=>
    array(2) {
      ["index"]=>
      int(4277)
      ["value"]=>
      float(0.02367769)
    }
    [792]=>
    array(2) {
      ["index"]=>
      int(4288)
      ["value"]=>
      float(0.043988783)
    }
    [793]=>
    array(2) {
      ["index"]=>
      int(4289)
      ["value"]=>
      float(0.029127907)
    }
    [794]=>
    array(2) {
      ["index"]=>
      int(4294)
      ["value"]=>
      float(0.048216388)
    }
    [795]=>
    array(2) {
      ["index"]=>
      int(4295)
      ["value"]=>
      float(0.030197093)
    }
    [796]=>
    array(2) {
      ["index"]=>
      int(4297)
      ["value"]=>
      float(0.102149636)
    }
    [797]=>
    array(2) {
      ["index"]=>
      int(4318)
      ["value"]=>
      float(0.0037123114)
    }
    [798]=>
    array(2) {
      ["index"]=>
      int(4329)
      ["value"]=>
      float(0.0078070983)
    }
    [799]=>
    array(2) {
      ["index"]=>
      int(4332)
      ["value"]=>
      float(0.029381566)
    }
    [800]=>
    array(2) {
      ["index"]=>
      int(4340)
      ["value"]=>
      float(0.048138116)
    }
    [801]=>
    array(2) {
      ["index"]=>
      int(4341)
      ["value"]=>
      float(0.0111221345)
    }
    [802]=>
    array(2) {
      ["index"]=>
      int(4353)
      ["value"]=>
      float(0.0118041355)
    }
    [803]=>
    array(2) {
      ["index"]=>
      int(4368)
      ["value"]=>
      float(0.0403381)
    }
    [804]=>
    array(2) {
      ["index"]=>
      int(4372)
      ["value"]=>
      float(0.061295446)
    }
    [805]=>
    array(2) {
      ["index"]=>
      int(4373)
      ["value"]=>
      float(0.033146318)
    }
    [806]=>
    array(2) {
      ["index"]=>
      int(4403)
      ["value"]=>
      float(0.018424325)
    }
    [807]=>
    array(2) {
      ["index"]=>
      int(4405)
      ["value"]=>
      float(0.0018354489)
    }
    [808]=>
    array(2) {
      ["index"]=>
      int(4410)
      ["value"]=>
      float(0.025509741)
    }
    [809]=>
    array(2) {
      ["index"]=>
      int(4429)
      ["value"]=>
      float(0.076688625)
    }
    [810]=>
    array(2) {
      ["index"]=>
      int(4430)
      ["value"]=>
      float(0.047789738)
    }
    [811]=>
    array(2) {
      ["index"]=>
      int(4435)
      ["value"]=>
      float(0.080683626)
    }
    [812]=>
    array(2) {
      ["index"]=>
      int(4439)
      ["value"]=>
      float(0.04049025)
    }
    [813]=>
    array(2) {
      ["index"]=>
      int(4442)
      ["value"]=>
      float(0.06097237)
    }
    [814]=>
    array(2) {
      ["index"]=>
      int(4447)
      ["value"]=>
      float(0.026868785)
    }
    [815]=>
    array(2) {
      ["index"]=>
      int(4450)
      ["value"]=>
      float(0.05060873)
    }
    [816]=>
    array(2) {
      ["index"]=>
      int(4458)
      ["value"]=>
      float(0.08596477)
    }
    [817]=>
    array(2) {
      ["index"]=>
      int(4462)
      ["value"]=>
      float(0.02936698)
    }
    [818]=>
    array(2) {
      ["index"]=>
      int(4470)
      ["value"]=>
      float(0.02700548)
    }
    [819]=>
    array(2) {
      ["index"]=>
      int(4484)
      ["value"]=>
      float(0.0043252017)
    }
    [820]=>
    array(2) {
      ["index"]=>
      int(4487)
      ["value"]=>
      float(0.13251705)
    }
    [821]=>
    array(2) {
      ["index"]=>
      int(4501)
      ["value"]=>
      float(0.0019456282)
    }
    [822]=>
    array(2) {
      ["index"]=>
      int(4502)
      ["value"]=>
      float(0.0036867762)
    }
    [823]=>
    array(2) {
      ["index"]=>
      int(4511)
      ["value"]=>
      float(0.02372484)
    }
    [824]=>
    array(2) {
      ["index"]=>
      int(4515)
      ["value"]=>
      float(0.07516559)
    }
    [825]=>
    array(2) {
      ["index"]=>
      int(4519)
      ["value"]=>
      float(0.057928264)
    }
    [826]=>
    array(2) {
      ["index"]=>
      int(4533)
      ["value"]=>
      float(0.016272347)
    }
    [827]=>
    array(2) {
      ["index"]=>
      int(4544)
      ["value"]=>
      float(0.072074495)
    }
    [828]=>
    array(2) {
      ["index"]=>
      int(4550)
      ["value"]=>
      float(0.046136975)
    }
    [829]=>
    array(2) {
      ["index"]=>
      int(4563)
      ["value"]=>
      float(0.010737501)
    }
    [830]=>
    array(2) {
      ["index"]=>
      int(4586)
      ["value"]=>
      float(0.041814353)
    }
    [831]=>
    array(2) {
      ["index"]=>
      int(4589)
      ["value"]=>
      float(0.046381917)
    }
    [832]=>
    array(2) {
      ["index"]=>
      int(4591)
      ["value"]=>
      float(0.06420145)
    }
    [833]=>
    array(2) {
      ["index"]=>
      int(4605)
      ["value"]=>
      float(0.015042912)
    }
    [834]=>
    array(2) {
      ["index"]=>
      int(4613)
      ["value"]=>
      float(0.0077344705)
    }
    [835]=>
    array(2) {
      ["index"]=>
      int(4635)
      ["value"]=>
      float(0.07871292)
    }
    [836]=>
    array(2) {
      ["index"]=>
      int(4641)
      ["value"]=>
      float(0.01934612)
    }
    [837]=>
    array(2) {
      ["index"]=>
      int(4651)
      ["value"]=>
      float(0.015252972)
    }
    [838]=>
    array(2) {
      ["index"]=>
      int(4654)
      ["value"]=>
      float(0.0612682)
    }
    [839]=>
    array(2) {
      ["index"]=>
      int(4658)
      ["value"]=>
      float(0.007880904)
    }
    [840]=>
    array(2) {
      ["index"]=>
      int(4668)
      ["value"]=>
      float(0.0026324878)
    }
    [841]=>
    array(2) {
      ["index"]=>
      int(4671)
      ["value"]=>
      float(0.020559885)
    }
    [842]=>
    array(2) {
      ["index"]=>
      int(4672)
      ["value"]=>
      float(0.00770608)
    }
    [843]=>
    array(2) {
      ["index"]=>
      int(4684)
      ["value"]=>
      float(0.055176556)
    }
    [844]=>
    array(2) {
      ["index"]=>
      int(4693)
      ["value"]=>
      float(0.022627847)
    }
    [845]=>
    array(2) {
      ["index"]=>
      int(4742)
      ["value"]=>
      float(0.057155877)
    }
    [846]=>
    array(2) {
      ["index"]=>
      int(4748)
      ["value"]=>
      float(0.10295334)
    }
    [847]=>
    array(2) {
      ["index"]=>
      int(4762)
      ["value"]=>
      float(0.03549752)
    }
    [848]=>
    array(2) {
      ["index"]=>
      int(4769)
      ["value"]=>
      float(0.064609535)
    }
    [849]=>
    array(2) {
      ["index"]=>
      int(4774)
      ["value"]=>
      float(0.013266742)
    }
    [850]=>
    array(2) {
      ["index"]=>
      int(4777)
      ["value"]=>
      float(0.04378718)
    }
    [851]=>
    array(2) {
      ["index"]=>
      int(4801)
      ["value"]=>
      float(0.013761876)
    }
    [852]=>
    array(2) {
      ["index"]=>
      int(4810)
      ["value"]=>
      float(0.0015741112)
    }
    [853]=>
    array(2) {
      ["index"]=>
      int(4811)
      ["value"]=>
      float(0.0037047104)
    }
    [854]=>
    array(2) {
      ["index"]=>
      int(4828)
      ["value"]=>
      float(0.015234305)
    }
    [855]=>
    array(2) {
      ["index"]=>
      int(4843)
      ["value"]=>
      float(0.047589242)
    }
    [856]=>
    array(2) {
      ["index"]=>
      int(4844)
      ["value"]=>
      float(0.011512866)
    }
    [857]=>
    array(2) {
      ["index"]=>
      int(4847)
      ["value"]=>
      float(0.047360744)
    }
    [858]=>
    array(2) {
      ["index"]=>
      int(4852)
      ["value"]=>
      float(0.023186628)
    }
    [859]=>
    array(2) {
      ["index"]=>
      int(4870)
      ["value"]=>
      float(0.14289956)
    }
    [860]=>
    array(2) {
      ["index"]=>
      int(4879)
      ["value"]=>
      float(0.033740513)
    }
    [861]=>
    array(2) {
      ["index"]=>
      int(4895)
      ["value"]=>
      float(0.07524963)
    }
    [862]=>
    array(2) {
      ["index"]=>
      int(4897)
      ["value"]=>
      float(0.011026639)
    }
    [863]=>
    array(2) {
      ["index"]=>
      int(4914)
      ["value"]=>
      float(0.008974572)
    }
    [864]=>
    array(2) {
      ["index"]=>
      int(4929)
      ["value"]=>
      float(0.043052897)
    }
    [865]=>
    array(2) {
      ["index"]=>
      int(4935)
      ["value"]=>
      float(0.036018338)
    }
    [866]=>
    array(2) {
      ["index"]=>
      int(4949)
      ["value"]=>
      float(0.053483993)
    }
    [867]=>
    array(2) {
      ["index"]=>
      int(4954)
      ["value"]=>
      float(0.03743599)
    }
    [868]=>
    array(2) {
      ["index"]=>
      int(4977)
      ["value"]=>
      float(0.07060084)
    }
    [869]=>
    array(2) {
      ["index"]=>
      int(4984)
      ["value"]=>
      float(0.030799286)
    }
    [870]=>
    array(2) {
      ["index"]=>
      int(4986)
      ["value"]=>
      float(0.0010503973)
    }
    [871]=>
    array(2) {
      ["index"]=>
      int(4994)
      ["value"]=>
      float(0.0038139713)
    }
    [872]=>
    array(2) {
      ["index"]=>
      int(4997)
      ["value"]=>
      float(0.090745136)
    }
    [873]=>
    array(2) {
      ["index"]=>
      int(5003)
      ["value"]=>
      float(0.064474195)
    }
    [874]=>
    array(2) {
      ["index"]=>
      int(5008)
      ["value"]=>
      float(0.09645038)
    }
    [875]=>
    array(2) {
      ["index"]=>
      int(5012)
      ["value"]=>
      float(0.051316094)
    }
    [876]=>
    array(2) {
      ["index"]=>
      int(5013)
      ["value"]=>
      float(0.0146927945)
    }
    [877]=>
    array(2) {
      ["index"]=>
      int(5020)
      ["value"]=>
      float(0.0847337)
    }
    [878]=>
    array(2) {
      ["index"]=>
      int(5022)
      ["value"]=>
      float(0.013380727)
    }
    [879]=>
    array(2) {
      ["index"]=>
      int(5033)
      ["value"]=>
      float(0.03289984)
    }
    [880]=>
    array(2) {
      ["index"]=>
      int(5085)
      ["value"]=>
      float(0.04352768)
    }
    [881]=>
    array(2) {
      ["index"]=>
      int(5094)
      ["value"]=>
      float(0.0039032714)
    }
    [882]=>
    array(2) {
      ["index"]=>
      int(5123)
      ["value"]=>
      float(0.12962458)
    }
    [883]=>
    array(2) {
      ["index"]=>
      int(5127)
      ["value"]=>
      float(0.0376895)
    }
    [884]=>
    array(2) {
      ["index"]=>
      int(5132)
      ["value"]=>
      float(0.0033808951)
    }
    [885]=>
    array(2) {
      ["index"]=>
      int(5169)
      ["value"]=>
      float(0.018758047)
    }
    [886]=>
    array(2) {
      ["index"]=>
      int(5175)
      ["value"]=>
      float(0.009908657)
    }
    [887]=>
    array(2) {
      ["index"]=>
      int(5210)
      ["value"]=>
      float(0.02719332)
    }
    [888]=>
    array(2) {
      ["index"]=>
      int(5229)
      ["value"]=>
      float(0.034725107)
    }
    [889]=>
    array(2) {
      ["index"]=>
      int(5243)
      ["value"]=>
      float(0.05073486)
    }
    [890]=>
    array(2) {
      ["index"]=>
      int(5279)
      ["value"]=>
      float(0.0060969316)
    }
    [891]=>
    array(2) {
      ["index"]=>
      int(5290)
      ["value"]=>
      float(0.02741047)
    }
    [892]=>
    array(2) {
      ["index"]=>
      int(5292)
      ["value"]=>
      float(0.037230078)
    }
    [893]=>
    array(2) {
      ["index"]=>
      int(5295)
      ["value"]=>
      float(0.056780666)
    }
    [894]=>
    array(2) {
      ["index"]=>
      int(5304)
      ["value"]=>
      float(0.018868366)
    }
    [895]=>
    array(2) {
      ["index"]=>
      int(5305)
      ["value"]=>
      float(0.03534679)
    }
    [896]=>
    array(2) {
      ["index"]=>
      int(5320)
      ["value"]=>
      float(0.006456942)
    }
    [897]=>
    array(2) {
      ["index"]=>
      int(5330)
      ["value"]=>
      float(0.028021414)
    }
    [898]=>
    array(2) {
      ["index"]=>
      int(5340)
      ["value"]=>
      float(0.010289833)
    }
    [899]=>
    array(2) {
      ["index"]=>
      int(5341)
      ["value"]=>
      float(0.011767025)
    }
    [900]=>
    array(2) {
      ["index"]=>
      int(5343)
      ["value"]=>
      float(0.004316062)
    }
    [901]=>
    array(2) {
      ["index"]=>
      int(5356)
      ["value"]=>
      float(0.030067774)
    }
    [902]=>
    array(2) {
      ["index"]=>
      int(5361)
      ["value"]=>
      float(0.017232452)
    }
    [903]=>
    array(2) {
      ["index"]=>
      int(5371)
      ["value"]=>
      float(0.005072937)
    }
    [904]=>
    array(2) {
      ["index"]=>
      int(5377)
      ["value"]=>
      float(0.03595049)
    }
    [905]=>
    array(2) {
      ["index"]=>
      int(5397)
      ["value"]=>
      float(0.02514246)
    }
    [906]=>
    array(2) {
      ["index"]=>
      int(5404)
      ["value"]=>
      float(0.05738733)
    }
    [907]=>
    array(2) {
      ["index"]=>
      int(5414)
      ["value"]=>
      float(0.046731014)
    }
    [908]=>
    array(2) {
      ["index"]=>
      int(5416)
      ["value"]=>
      float(0.007888119)
    }
    [909]=>
    array(2) {
      ["index"]=>
      int(5438)
      ["value"]=>
      float(0.14985798)
    }
    [910]=>
    array(2) {
      ["index"]=>
      int(5464)
      ["value"]=>
      float(0.025648134)
    }
    [911]=>
    array(2) {
      ["index"]=>
      int(5477)
      ["value"]=>
      float(0.0066084177)
    }
    [912]=>
    array(2) {
      ["index"]=>
      int(5480)
      ["value"]=>
      float(0.0009151085)
    }
    [913]=>
    array(2) {
      ["index"]=>
      int(5512)
      ["value"]=>
      float(0.011396193)
    }
    [914]=>
    array(2) {
      ["index"]=>
      int(5519)
      ["value"]=>
      float(0.058096435)
    }
    [915]=>
    array(2) {
      ["index"]=>
      int(5527)
      ["value"]=>
      float(0.022818493)
    }
    [916]=>
    array(2) {
      ["index"]=>
      int(5536)
      ["value"]=>
      float(0.06369377)
    }
    [917]=>
    array(2) {
      ["index"]=>
      int(5549)
      ["value"]=>
      float(0.017725628)
    }
    [918]=>
    array(2) {
      ["index"]=>
      int(5558)
      ["value"]=>
      float(0.0060112635)
    }
    [919]=>
    array(2) {
      ["index"]=>
      int(5559)
      ["value"]=>
      float(0.061013535)
    }
    [920]=>
    array(2) {
      ["index"]=>
      int(5561)
      ["value"]=>
      float(0.04639717)
    }
    [921]=>
    array(2) {
      ["index"]=>
      int(5572)
      ["value"]=>
      float(0.04620163)
    }
    [922]=>
    array(2) {
      ["index"]=>
      int(5587)
      ["value"]=>
      float(0.058285948)
    }
    [923]=>
    array(2) {
      ["index"]=>
      int(5604)
      ["value"]=>
      float(0.03521963)
    }
    [924]=>
    array(2) {
      ["index"]=>
      int(5622)
      ["value"]=>
      float(0.058788292)
    }
    [925]=>
    array(2) {
      ["index"]=>
      int(5635)
      ["value"]=>
      float(0.04058801)
    }
    [926]=>
    array(2) {
      ["index"]=>
      int(5637)
      ["value"]=>
      float(0.042594906)
    }
    [927]=>
    array(2) {
      ["index"]=>
      int(5648)
      ["value"]=>
      float(0.13004659)
    }
    [928]=>
    array(2) {
      ["index"]=>
      int(5653)
      ["value"]=>
      float(0.10030525)
    }
    [929]=>
    array(2) {
      ["index"]=>
      int(5654)
      ["value"]=>
      float(0.058134455)
    }
    [930]=>
    array(2) {
      ["index"]=>
      int(5675)
      ["value"]=>
      float(0.040686563)
    }
    [931]=>
    array(2) {
      ["index"]=>
      int(5685)
      ["value"]=>
      float(0.025391202)
    }
    [932]=>
    array(2) {
      ["index"]=>
      int(5717)
      ["value"]=>
      float(0.03377855)
    }
    [933]=>
    array(2) {
      ["index"]=>
      int(5754)
      ["value"]=>
      float(0.0334106)
    }
    [934]=>
    array(2) {
      ["index"]=>
      int(5796)
      ["value"]=>
      float(0.012573024)
    }
    [935]=>
    array(2) {
      ["index"]=>
      int(5805)
      ["value"]=>
      float(0.021725288)
    }
    [936]=>
    array(2) {
      ["index"]=>
      int(5812)
      ["value"]=>
      float(0.083905466)
    }
    [937]=>
    array(2) {
      ["index"]=>
      int(5813)
      ["value"]=>
      float(0.009928958)
    }
    [938]=>
    array(2) {
      ["index"]=>
      int(5825)
      ["value"]=>
      float(0.034904364)
    }
    [939]=>
    array(2) {
      ["index"]=>
      int(5831)
      ["value"]=>
      float(0.01773687)
    }
    [940]=>
    array(2) {
      ["index"]=>
      int(5883)
      ["value"]=>
      float(0.056056537)
    }
    [941]=>
    array(2) {
      ["index"]=>
      int(5887)
      ["value"]=>
      float(0.007696025)
    }
    [942]=>
    array(2) {
      ["index"]=>
      int(5902)
      ["value"]=>
      float(0.1535155)
    }
    [943]=>
    array(2) {
      ["index"]=>
      int(5907)
      ["value"]=>
      float(0.004043262)
    }
    [944]=>
    array(2) {
      ["index"]=>
      int(5933)
      ["value"]=>
      float(0.0011878109)
    }
    [945]=>
    array(2) {
      ["index"]=>
      int(5950)
      ["value"]=>
      float(0.14177391)
    }
    [946]=>
    array(2) {
      ["index"]=>
      int(5970)
      ["value"]=>
      float(0.028149145)
    }
    [947]=>
    array(2) {
      ["index"]=>
      int(5997)
      ["value"]=>
      float(0.023831818)
    }
    [948]=>
    array(2) {
      ["index"]=>
      int(6046)
      ["value"]=>
      float(0.037518203)
    }
    [949]=>
    array(2) {
      ["index"]=>
      int(6067)
      ["value"]=>
      float(0.0014888879)
    }
    [950]=>
    array(2) {
      ["index"]=>
      int(6074)
      ["value"]=>
      float(0.040258978)
    }
    [951]=>
    array(2) {
      ["index"]=>
      int(6090)
      ["value"]=>
      float(0.13847882)
    }
    [952]=>
    array(2) {
      ["index"]=>
      int(6097)
      ["value"]=>
      float(0.04463711)
    }
    [953]=>
    array(2) {
      ["index"]=>
      int(6099)
      ["value"]=>
      float(0.023381824)
    }
    [954]=>
    array(2) {
      ["index"]=>
      int(6101)
      ["value"]=>
      float(0.0074862656)
    }
    [955]=>
    array(2) {
      ["index"]=>
      int(6112)
      ["value"]=>
      float(0.04133761)
    }
    [956]=>
    array(2) {
      ["index"]=>
      int(6120)
      ["value"]=>
      float(0.0046795616)
    }
    [957]=>
    array(2) {
      ["index"]=>
      int(6154)
      ["value"]=>
      float(0.0002479246)
    }
    [958]=>
    array(2) {
      ["index"]=>
      int(6184)
      ["value"]=>
      float(0.013411544)
    }
    [959]=>
    array(2) {
      ["index"]=>
      int(6187)
      ["value"]=>
      float(0.06272823)
    }
    [960]=>
    array(2) {
      ["index"]=>
      int(6200)
      ["value"]=>
      float(0.035266697)
    }
    [961]=>
    array(2) {
      ["index"]=>
      int(6204)
      ["value"]=>
      float(0.00785441)
    }
    [962]=>
    array(2) {
      ["index"]=>
      int(6226)
      ["value"]=>
      float(0.042632718)
    }
    [963]=>
    array(2) {
      ["index"]=>
      int(6261)
      ["value"]=>
      float(0.041259255)
    }
    [964]=>
    array(2) {
      ["index"]=>
      int(6299)
      ["value"]=>
      float(0.010464205)
    }
    [965]=>
    array(2) {
      ["index"]=>
      int(6302)
      ["value"]=>
      float(0.046695407)
    }
    [966]=>
    array(2) {
      ["index"]=>
      int(6314)
      ["value"]=>
      float(0.053309277)
    }
    [967]=>
    array(2) {
      ["index"]=>
      int(6338)
      ["value"]=>
      float(0.046816904)
    }
    [968]=>
    array(2) {
      ["index"]=>
      int(6348)
      ["value"]=>
      float(0.011051987)
    }
    [969]=>
    array(2) {
      ["index"]=>
      int(6375)
      ["value"]=>
      float(0.010033765)
    }
    [970]=>
    array(2) {
      ["index"]=>
      int(6397)
      ["value"]=>
      float(0.007833475)
    }
    [971]=>
    array(2) {
      ["index"]=>
      int(6410)
      ["value"]=>
      float(0.09484474)
    }
    [972]=>
    array(2) {
      ["index"]=>
      int(6418)
      ["value"]=>
      float(0.0033936072)
    }
    [973]=>
    array(2) {
      ["index"]=>
      int(6454)
      ["value"]=>
      float(0.012748412)
    }
    [974]=>
    array(2) {
      ["index"]=>
      int(6463)
      ["value"]=>
      float(0.012104389)
    }
    [975]=>
    array(2) {
      ["index"]=>
      int(6465)
      ["value"]=>
      float(0.0032478224)
    }
    [976]=>
    array(2) {
      ["index"]=>
      int(6468)
      ["value"]=>
      float(0.04025932)
    }
    [977]=>
    array(2) {
      ["index"]=>
      int(6469)
      ["value"]=>
      float(0.05550512)
    }
    [978]=>
    array(2) {
      ["index"]=>
      int(6472)
      ["value"]=>
      float(0.007874753)
    }
    [979]=>
    array(2) {
      ["index"]=>
      int(6490)
      ["value"]=>
      float(0.012344033)
    }
    [980]=>
    array(2) {
      ["index"]=>
      int(6519)
      ["value"]=>
      float(0.063704506)
    }
    [981]=>
    array(2) {
      ["index"]=>
      int(6522)
      ["value"]=>
      float(0.0025592453)
    }
    [982]=>
    array(2) {
      ["index"]=>
      int(6534)
      ["value"]=>
      float(0.06930555)
    }
    [983]=>
    array(2) {
      ["index"]=>
      int(6536)
      ["value"]=>
      float(0.023206778)
    }
    [984]=>
    array(2) {
      ["index"]=>
      int(6540)
      ["value"]=>
      float(0.010059256)
    }
    [985]=>
    array(2) {
      ["index"]=>
      int(6541)
      ["value"]=>
      float(0.03843198)
    }
    [986]=>
    array(2) {
      ["index"]=>
      int(6544)
      ["value"]=>
      float(0.067212395)
    }
    [987]=>
    array(2) {
      ["index"]=>
      int(6556)
      ["value"]=>
      float(0.016425978)
    }
    [988]=>
    array(2) {
      ["index"]=>
      int(6583)
      ["value"]=>
      float(0.0045294547)
    }
    [989]=>
    array(2) {
      ["index"]=>
      int(6632)
      ["value"]=>
      float(0.02611151)
    }
    [990]=>
    array(2) {
      ["index"]=>
      int(6638)
      ["value"]=>
      float(0.10201229)
    }
    [991]=>
    array(2) {
      ["index"]=>
      int(6643)
      ["value"]=>
      float(0.052414432)
    }
    [992]=>
    array(2) {
      ["index"]=>
      int(6645)
      ["value"]=>
      float(0.014965876)
    }
    [993]=>
    array(2) {
      ["index"]=>
      int(6679)
      ["value"]=>
      float(0.054375287)
    }
    [994]=>
    array(2) {
      ["index"]=>
      int(6696)
      ["value"]=>
      float(0.023213767)
    }
    [995]=>
    array(2) {
      ["index"]=>
      int(6711)
      ["value"]=>
      float(0.029317664)
    }
    [996]=>
    array(2) {
      ["index"]=>
      int(6721)
      ["value"]=>
      float(0.014988424)
    }
    [997]=>
    array(2) {
      ["index"]=>
      int(6728)
      ["value"]=>
      float(0.07404072)
    }
    [998]=>
    array(2) {
      ["index"]=>
      int(6738)
      ["value"]=>
      float(0.04557459)
    }
    [999]=>
    array(2) {
      ["index"]=>
      int(6762)
      ["value"]=>
      float(0.0058160834)
    }
    [1000]=>
    array(2) {
      ["index"]=>
      int(6820)
      ["value"]=>
      float(0.002896164)
    }
    [1001]=>
    array(2) {
      ["index"]=>
      int(6849)
      ["value"]=>
      float(0.04733334)
    }
    [1002]=>
    array(2) {
      ["index"]=>
      int(6901)
      ["value"]=>
      float(0.003590686)
    }
    [1003]=>
    array(2) {
      ["index"]=>
      int(6904)
      ["value"]=>
      float(0.02454697)
    }
    [1004]=>
    array(2) {
      ["index"]=>
      int(6949)
      ["value"]=>
      float(0.011543506)
    }
    [1005]=>
    array(2) {
      ["index"]=>
      int(6971)
      ["value"]=>
      float(0.031074477)
    }
    [1006]=>
    array(2) {
      ["index"]=>
      int(7017)
      ["value"]=>
      float(0.005666147)
    }
    [1007]=>
    array(2) {
      ["index"]=>
      int(7020)
      ["value"]=>
      float(0.014943797)
    }
    [1008]=>
    array(2) {
      ["index"]=>
      int(7065)
      ["value"]=>
      float(0.07501033)
    }
    [1009]=>
    array(2) {
      ["index"]=>
      int(7087)
      ["value"]=>
      float(0.05051569)
    }
    [1010]=>
    array(2) {
      ["index"]=>
      int(7166)
      ["value"]=>
      float(0.078696385)
    }
    [1011]=>
    array(2) {
      ["index"]=>
      int(7185)
      ["value"]=>
      float(0.037261087)
    }
    [1012]=>
    array(2) {
      ["index"]=>
      int(7192)
      ["value"]=>
      float(0.016079511)
    }
    [1013]=>
    array(2) {
      ["index"]=>
      int(7198)
      ["value"]=>
      float(0.09711124)
    }
    [1014]=>
    array(2) {
      ["index"]=>
      int(7221)
      ["value"]=>
      float(0.017633688)
    }
    [1015]=>
    array(2) {
      ["index"]=>
      int(7304)
      ["value"]=>
      float(0.04073349)
    }
    [1016]=>
    array(2) {
      ["index"]=>
      int(7341)
      ["value"]=>
      float(0.009250401)
    }
    [1017]=>
    array(2) {
      ["index"]=>
      int(7349)
      ["value"]=>
      float(0.0015061474)
    }
    [1018]=>
    array(2) {
      ["index"]=>
      int(7360)
      ["value"]=>
      float(0.007109108)
    }
    [1019]=>
    array(2) {
      ["index"]=>
      int(7367)
      ["value"]=>
      float(0.017242646)
    }
    [1020]=>
    array(2) {
      ["index"]=>
      int(7386)
      ["value"]=>
      float(0.0043757646)
    }
    [1021]=>
    array(2) {
      ["index"]=>
      int(7402)
      ["value"]=>
      float(0.015977215)
    }
    [1022]=>
    array(2) {
      ["index"]=>
      int(7408)
      ["value"]=>
      float(0.013581963)
    }
    [1023]=>
    array(2) {
      ["index"]=>
      int(7473)
      ["value"]=>
      float(0.030672703)
    }
    [1024]=>
    array(2) {
      ["index"]=>
      int(7490)
      ["value"]=>
      float(0.003176051)
    }
    [1025]=>
    array(2) {
      ["index"]=>
      int(7505)
      ["value"]=>
      float(0.027252253)
    }
    [1026]=>
    array(2) {
      ["index"]=>
      int(7532)
      ["value"]=>
      float(0.055469595)
    }
    [1027]=>
    array(2) {
      ["index"]=>
      int(7701)
      ["value"]=>
      float(0.026777798)
    }
    [1028]=>
    array(2) {
      ["index"]=>
      int(7760)
      ["value"]=>
      float(0.10730435)
    }
    [1029]=>
    array(2) {
      ["index"]=>
      int(7773)
      ["value"]=>
      float(0.0011405399)
    }
    [1030]=>
    array(2) {
      ["index"]=>
      int(7782)
      ["value"]=>
      float(0.03900894)
    }
    [1031]=>
    array(2) {
      ["index"]=>
      int(7807)
      ["value"]=>
      float(0.0029312286)
    }
    [1032]=>
    array(2) {
      ["index"]=>
      int(7861)
      ["value"]=>
      float(0.038392633)
    }
    [1033]=>
    array(2) {
      ["index"]=>
      int(7865)
      ["value"]=>
      float(0.0024691115)
    }
    [1034]=>
    array(2) {
      ["index"]=>
      int(7874)
      ["value"]=>
      float(0.03376829)
    }
    [1035]=>
    array(2) {
      ["index"]=>
      int(7959)
      ["value"]=>
      float(0.021210507)
    }
    [1036]=>
    array(2) {
      ["index"]=>
      int(8018)
      ["value"]=>
      float(0.034243587)
    }
    [1037]=>
    array(2) {
      ["index"]=>
      int(8021)
      ["value"]=>
      float(0.04258131)
    }
    [1038]=>
    array(2) {
      ["index"]=>
      int(8040)
      ["value"]=>
      float(0.062282417)
    }
    [1039]=>
    array(2) {
      ["index"]=>
      int(8046)
      ["value"]=>
      float(0.0033115093)
    }
    [1040]=>
    array(2) {
      ["index"]=>
      int(8079)
      ["value"]=>
      float(0.030358776)
    }
    [1041]=>
    array(2) {
      ["index"]=>
      int(8080)
      ["value"]=>
      float(0.031167384)
    }
    [1042]=>
    array(2) {
      ["index"]=>
      int(8110)
      ["value"]=>
      float(0.007967003)
    }
    [1043]=>
    array(2) {
      ["index"]=>
      int(8177)
      ["value"]=>
      float(0.023587229)
    }
    [1044]=>
    array(2) {
      ["index"]=>
      int(8181)
      ["value"]=>
      float(0.025802886)
    }
    [1045]=>
    array(2) {
      ["index"]=>
      int(8222)
      ["value"]=>
      float(0.0050075827)
    }
    [1046]=>
    array(2) {
      ["index"]=>
      int(8247)
      ["value"]=>
      float(0.03497781)
    }
    [1047]=>
    array(2) {
      ["index"]=>
      int(8254)
      ["value"]=>
      float(0.031648308)
    }
    [1048]=>
    array(2) {
      ["index"]=>
      int(8273)
      ["value"]=>
      float(0.0016058895)
    }
    [1049]=>
    array(2) {
      ["index"]=>
      int(8276)
      ["value"]=>
      float(0.005856379)
    }
    [1050]=>
    array(2) {
      ["index"]=>
      int(8292)
      ["value"]=>
      float(0.013337088)
    }
    [1051]=>
    array(2) {
      ["index"]=>
      int(8485)
      ["value"]=>
      float(0.07782056)
    }
    [1052]=>
    array(2) {
      ["index"]=>
      int(8486)
      ["value"]=>
      float(0.025033876)
    }
    [1053]=>
    array(2) {
      ["index"]=>
      int(8494)
      ["value"]=>
      float(0.013170039)
    }
    [1054]=>
    array(2) {
      ["index"]=>
      int(8524)
      ["value"]=>
      float(0.0068666674)
    }
    [1055]=>
    array(2) {
      ["index"]=>
      int(8548)
      ["value"]=>
      float(0.066082336)
    }
    [1056]=>
    array(2) {
      ["index"]=>
      int(8589)
      ["value"]=>
      float(0.011944674)
    }
    [1057]=>
    array(2) {
      ["index"]=>
      int(8610)
      ["value"]=>
      float(0.008569728)
    }
    [1058]=>
    array(2) {
      ["index"]=>
      int(8730)
      ["value"]=>
      float(0.031513747)
    }
    [1059]=>
    array(2) {
      ["index"]=>
      int(8737)
      ["value"]=>
      float(0.0022601555)
    }
    [1060]=>
    array(2) {
      ["index"]=>
      int(8738)
      ["value"]=>
      float(0.030907938)
    }
    [1061]=>
    array(2) {
      ["index"]=>
      int(8785)
      ["value"]=>
      float(0.026049376)
    }
    [1062]=>
    array(2) {
      ["index"]=>
      int(8827)
      ["value"]=>
      float(0.06566692)
    }
    [1063]=>
    array(2) {
      ["index"]=>
      int(8840)
      ["value"]=>
      float(0.0063877692)
    }
    [1064]=>
    array(2) {
      ["index"]=>
      int(8846)
      ["value"]=>
      float(0.030998435)
    }
    [1065]=>
    array(2) {
      ["index"]=>
      int(8909)
      ["value"]=>
      float(0.01033219)
    }
    [1066]=>
    array(2) {
      ["index"]=>
      int(8934)
      ["value"]=>
      float(0.0040608337)
    }
    [1067]=>
    array(2) {
      ["index"]=>
      int(9039)
      ["value"]=>
      float(0.007662192)
    }
    [1068]=>
    array(2) {
      ["index"]=>
      int(9043)
      ["value"]=>
      float(0.040070597)
    }
    [1069]=>
    array(2) {
      ["index"]=>
      int(9048)
      ["value"]=>
      float(0.009899214)
    }
    [1070]=>
    array(2) {
      ["index"]=>
      int(9052)
      ["value"]=>
      float(0.02133701)
    }
    [1071]=>
    array(2) {
      ["index"]=>
      int(9092)
      ["value"]=>
      float(0.031090423)
    }
    [1072]=>
    array(2) {
      ["index"]=>
      int(9152)
      ["value"]=>
      float(0.09616598)
    }
    [1073]=>
    array(2) {
      ["index"]=>
      int(9331)
      ["value"]=>
      float(0.05813153)
    }
    [1074]=>
    array(2) {
      ["index"]=>
      int(9335)
      ["value"]=>
      float(0.017182417)
    }
    [1075]=>
    array(2) {
      ["index"]=>
      int(9345)
      ["value"]=>
      float(0.06611124)
    }
    [1076]=>
    array(2) {
      ["index"]=>
      int(9396)
      ["value"]=>
      float(0.014564273)
    }
    [1077]=>
    array(2) {
      ["index"]=>
      int(9398)
      ["value"]=>
      float(0.012008045)
    }
    [1078]=>
    array(2) {
      ["index"]=>
      int(9499)
      ["value"]=>
      float(0.03476909)
    }
    [1079]=>
    array(2) {
      ["index"]=>
      int(9530)
      ["value"]=>
      float(0.012407732)
    }
    [1080]=>
    array(2) {
      ["index"]=>
      int(9547)
      ["value"]=>
      float(0.058216672)
    }
    [1081]=>
    array(2) {
      ["index"]=>
      int(9565)
      ["value"]=>
      float(0.039529655)
    }
    [1082]=>
    array(2) {
      ["index"]=>
      int(9587)
      ["value"]=>
      float(0.007887646)
    }
    [1083]=>
    array(2) {
      ["index"]=>
      int(9626)
      ["value"]=>
      float(0.04543654)
    }
    [1084]=>
    array(2) {
      ["index"]=>
      int(9677)
      ["value"]=>
      float(0.016298385)
    }
    [1085]=>
    array(2) {
      ["index"]=>
      int(9698)
      ["value"]=>
      float(0.007963928)
    }
    [1086]=>
    array(2) {
      ["index"]=>
      int(9700)
      ["value"]=>
      float(6.782779E-5)
    }
    [1087]=>
    array(2) {
      ["index"]=>
      int(9765)
      ["value"]=>
      float(0.029311066)
    }
    [1088]=>
    array(2) {
      ["index"]=>
      int(9808)
      ["value"]=>
      float(0.007162489)
    }
    [1089]=>
    array(2) {
      ["index"]=>
      int(9924)
      ["value"]=>
      float(0.00013290952)
    }
    [1090]=>
    array(2) {
      ["index"]=>
      int(10007)
      ["value"]=>
      float(0.013388255)
    }
    [1091]=>
    array(2) {
      ["index"]=>
      int(10014)
      ["value"]=>
      float(0.015528718)
    }
    [1092]=>
    array(2) {
      ["index"]=>
      int(10047)
      ["value"]=>
      float(0.0063559054)
    }
    [1093]=>
    array(2) {
      ["index"]=>
      int(10052)
      ["value"]=>
      float(0.011900972)
    }
    [1094]=>
    array(2) {
      ["index"]=>
      int(10055)
      ["value"]=>
      float(0.11548203)
    }
    [1095]=>
    array(2) {
      ["index"]=>
      int(10086)
      ["value"]=>
      float(0.0315931)
    }
    [1096]=>
    array(2) {
      ["index"]=>
      int(10093)
      ["value"]=>
      float(0.0035132372)
    }
    [1097]=>
    array(2) {
      ["index"]=>
      int(10174)
      ["value"]=>
      float(0.00013410146)
    }
    [1098]=>
    array(2) {
      ["index"]=>
      int(10210)
      ["value"]=>
      float(0.041087653)
    }
    [1099]=>
    array(2) {
      ["index"]=>
      int(10222)
      ["value"]=>
      float(0.011028878)
    }
    [1100]=>
    array(2) {
      ["index"]=>
      int(10514)
      ["value"]=>
      float(0.0049609663)
    }
    [1101]=>
    array(2) {
      ["index"]=>
      int(10524)
      ["value"]=>
      float(0.011040551)
    }
    [1102]=>
    array(2) {
      ["index"]=>
      int(10654)
      ["value"]=>
      float(0.06628785)
    }
    [1103]=>
    array(2) {
      ["index"]=>
      int(10696)
      ["value"]=>
      float(0.008598094)
    }
    [1104]=>
    array(2) {
      ["index"]=>
      int(10732)
      ["value"]=>
      float(0.01260834)
    }
    [1105]=>
    array(2) {
      ["index"]=>
      int(10755)
      ["value"]=>
      float(0.0036232318)
    }
    [1106]=>
    array(2) {
      ["index"]=>
      int(10768)
      ["value"]=>
      float(0.006904434)
    }
    [1107]=>
    array(2) {
      ["index"]=>
      int(10943)
      ["value"]=>
      float(0.038694985)
    }
    [1108]=>
    array(2) {
      ["index"]=>
      int(10958)
      ["value"]=>
      float(0.008389587)
    }
    [1109]=>
    array(2) {
      ["index"]=>
      int(10973)
      ["value"]=>
      float(0.0005696581)
    }
    [1110]=>
    array(2) {
      ["index"]=>
      int(11022)
      ["value"]=>
      float(0.03325333)
    }
    [1111]=>
    array(2) {
      ["index"]=>
      int(11113)
      ["value"]=>
      float(0.044494364)
    }
    [1112]=>
    array(2) {
      ["index"]=>
      int(11163)
      ["value"]=>
      float(0.06103159)
    }
    [1113]=>
    array(2) {
      ["index"]=>
      int(11208)
      ["value"]=>
      float(0.03584181)
    }
    [1114]=>
    array(2) {
      ["index"]=>
      int(11320)
      ["value"]=>
      float(0.03831095)
    }
    [1115]=>
    array(2) {
      ["index"]=>
      int(11360)
      ["value"]=>
      float(0.007852518)
    }
    [1116]=>
    array(2) {
      ["index"]=>
      int(11443)
      ["value"]=>
      float(0.061903298)
    }
    [1117]=>
    array(2) {
      ["index"]=>
      int(11477)
      ["value"]=>
      float(0.03907108)
    }
    [1118]=>
    array(2) {
      ["index"]=>
      int(11498)
      ["value"]=>
      float(0.042475063)
    }
    [1119]=>
    array(2) {
      ["index"]=>
      int(11565)
      ["value"]=>
      float(0.00018928644)
    }
    [1120]=>
    array(2) {
      ["index"]=>
      int(11631)
      ["value"]=>
      float(0.014638991)
    }
    [1121]=>
    array(2) {
      ["index"]=>
      int(11819)
      ["value"]=>
      float(0.0067720665)
    }
    [1122]=>
    array(2) {
      ["index"]=>
      int(11918)
      ["value"]=>
      float(0.01492207)
    }
    [1123]=>
    array(2) {
      ["index"]=>
      int(11937)
      ["value"]=>
      float(0.01651756)
    }
    [1124]=>
    array(2) {
      ["index"]=>
      int(12005)
      ["value"]=>
      float(0.012305059)
    }
    [1125]=>
    array(2) {
      ["index"]=>
      int(12121)
      ["value"]=>
      float(0.004177297)
    }
    [1126]=>
    array(2) {
      ["index"]=>
      int(12403)
      ["value"]=>
      float(0.042499512)
    }
    [1127]=>
    array(2) {
      ["index"]=>
      int(12419)
      ["value"]=>
      float(0.061271563)
    }
    [1128]=>
    array(2) {
      ["index"]=>
      int(12436)
      ["value"]=>
      float(0.017523935)
    }
    [1129]=>
    array(2) {
      ["index"]=>
      int(12456)
      ["value"]=>
      float(0.014281328)
    }
    [1130]=>
    array(2) {
      ["index"]=>
      int(12541)
      ["value"]=>
      float(0.020764003)
    }
    [1131]=>
    array(2) {
      ["index"]=>
      int(12681)
      ["value"]=>
      float(0.013357202)
    }
    [1132]=>
    array(2) {
      ["index"]=>
      int(12731)
      ["value"]=>
      float(0.0061574755)
    }
    [1133]=>
    array(2) {
      ["index"]=>
      int(13091)
      ["value"]=>
      float(0.031733885)
    }
    [1134]=>
    array(2) {
      ["index"]=>
      int(13433)
      ["value"]=>
      float(0.011846664)
    }
    [1135]=>
    array(2) {
      ["index"]=>
      int(13462)
      ["value"]=>
      float(0.0008774721)
    }
    [1136]=>
    array(2) {
      ["index"]=>
      int(13465)
      ["value"]=>
      float(0.031362068)
    }
    [1137]=>
    array(2) {
      ["index"]=>
      int(13571)
      ["value"]=>
      float(0.038985096)
    }
    [1138]=>
    array(2) {
      ["index"]=>
      int(13594)
      ["value"]=>
      float(0.0032083725)
    }
    [1139]=>
    array(2) {
      ["index"]=>
      int(13675)
      ["value"]=>
      float(0.041912556)
    }
    [1140]=>
    array(2) {
      ["index"]=>
      int(14017)
      ["value"]=>
      float(0.010567777)
    }
    [1141]=>
    array(2) {
      ["index"]=>
      int(14163)
      ["value"]=>
      float(0.0016152919)
    }
    [1142]=>
    array(2) {
      ["index"]=>
      int(14172)
      ["value"]=>
      float(0.040116753)
    }
    [1143]=>
    array(2) {
      ["index"]=>
      int(14406)
      ["value"]=>
      float(0.0061888713)
    }
    [1144]=>
    array(2) {
      ["index"]=>
      int(14520)
      ["value"]=>
      float(0.026372785)
    }
    [1145]=>
    array(2) {
      ["index"]=>
      int(14548)
      ["value"]=>
      float(0.0039980253)
    }
    [1146]=>
    array(2) {
      ["index"]=>
      int(14638)
      ["value"]=>
      float(0.009471954)
    }
    [1147]=>
    array(2) {
      ["index"]=>
      int(14739)
      ["value"]=>
      float(0.0143602975)
    }
    [1148]=>
    array(2) {
      ["index"]=>
      int(14891)
      ["value"]=>
      float(0.014309414)
    }
    [1149]=>
    array(2) {
      ["index"]=>
      int(14971)
      ["value"]=>
      float(0.027241347)
    }
    [1150]=>
    array(2) {
      ["index"]=>
      int(15017)
      ["value"]=>
      float(0.006699008)
    }
    [1151]=>
    array(2) {
      ["index"]=>
      int(15134)
      ["value"]=>
      float(0.023205264)
    }
    [1152]=>
    array(2) {
      ["index"]=>
      int(15544)
      ["value"]=>
      float(0.045490988)
    }
    [1153]=>
    array(2) {
      ["index"]=>
      int(15578)
      ["value"]=>
      float(0.021632198)
    }
    [1154]=>
    array(2) {
      ["index"]=>
      int(15671)
      ["value"]=>
      float(0.010447336)
    }
    [1155]=>
    array(2) {
      ["index"]=>
      int(16007)
      ["value"]=>
      float(0.08178996)
    }
    [1156]=>
    array(2) {
      ["index"]=>
      int(16280)
      ["value"]=>
      float(0.0012411518)
    }
    [1157]=>
    array(2) {
      ["index"]=>
      int(16295)
      ["value"]=>
      float(0.013880272)
    }
    [1158]=>
    array(2) {
      ["index"]=>
      int(16416)
      ["value"]=>
      float(0.027054098)
    }
    [1159]=>
    array(2) {
      ["index"]=>
      int(17053)
      ["value"]=>
      float(0.024389345)
    }
    [1160]=>
    array(2) {
      ["index"]=>
      int(17180)
      ["value"]=>
      float(0.009147638)
    }
    [1161]=>
    array(2) {
      ["index"]=>
      int(18168)
      ["value"]=>
      float(0.036096875)
    }
    [1162]=>
    array(2) {
      ["index"]=>
      int(18282)
      ["value"]=>
      float(0.027836744)
    }
    [1163]=>
    array(2) {
      ["index"]=>
      int(18749)
      ["value"]=>
      float(0.0016361197)
    }
    [1164]=>
    array(2) {
      ["index"]=>
      int(18981)
      ["value"]=>
      float(0.045215406)
    }
    [1165]=>
    array(2) {
      ["index"]=>
      int(19330)
      ["value"]=>
      float(0.016876066)
    }
    [1166]=>
    array(2) {
      ["index"]=>
      int(19429)
      ["value"]=>
      float(0.012361931)
    }
    [1167]=>
    array(2) {
      ["index"]=>
      int(19761)
      ["value"]=>
      float(0.027094822)
    }
    [1168]=>
    array(2) {
      ["index"]=>
      int(19857)
      ["value"]=>
      float(0.025492657)
    }
    [1169]=>
    array(2) {
      ["index"]=>
      int(19939)
      ["value"]=>
      float(0.009390235)
    }
    [1170]=>
    array(2) {
      ["index"]=>
      int(20066)
      ["value"]=>
      float(0.02770074)
    }
    [1171]=>
    array(2) {
      ["index"]=>
      int(20739)
      ["value"]=>
      float(0.018492084)
    }
    [1172]=>
    array(2) {
      ["index"]=>
      int(21396)
      ["value"]=>
      float(0.0801475)
    }
    [1173]=>
    array(2) {
      ["index"]=>
      int(22134)
      ["value"]=>
      float(0.031595178)
    }
    [1174]=>
    array(2) {
      ["index"]=>
      int(22195)
      ["value"]=>
      float(0.008935347)
    }
    [1175]=>
    array(2) {
      ["index"]=>
      int(22291)
      ["value"]=>
      float(0.02613555)
    }
    [1176]=>
    array(2) {
      ["index"]=>
      int(22648)
      ["value"]=>
      float(0.048307944)
    }
    [1177]=>
    array(2) {
      ["index"]=>
      int(23569)
      ["value"]=>
      float(0.012115107)
    }
    [1178]=>
    array(2) {
      ["index"]=>
      int(24188)
      ["value"]=>
      float(0.039678495)
    }
    [1179]=>
    array(2) {
      ["index"]=>
      int(24296)
      ["value"]=>
      float(0.018253442)
    }
    [1180]=>
    array(2) {
      ["index"]=>
      int(24471)
      ["value"]=>
      float(0.00067878567)
    }
    [1181]=>
    array(2) {
      ["index"]=>
      int(24799)
      ["value"]=>
      float(0.025667885)
    }
    [1182]=>
    array(2) {
      ["index"]=>
      int(25312)
      ["value"]=>
      float(0.050821196)
    }
    [1183]=>
    array(2) {
      ["index"]=>
      int(26709)
      ["value"]=>
      float(0.015902713)
    }
    [1184]=>
    array(2) {
      ["index"]=>
      int(26927)
      ["value"]=>
      float(0.03765173)
    }
    [1185]=>
    array(2) {
      ["index"]=>
      int(27327)
      ["value"]=>
      float(0.020856237)
    }
    [1186]=>
    array(2) {
      ["index"]=>
      int(28855)
      ["value"]=>
      float(0.07129831)
    }
    [1187]=>
    array(2) {
      ["index"]=>
      int(29477)
      ["value"]=>
      float(0.03251057)
    }
    [1188]=>
    array(2) {
      ["index"]=>
      int(29525)
      ["value"]=>
      float(0.018336898)
    }
    [1189]=>
    array(2) {
      ["index"]=>
      int(29536)
      ["value"]=>
      float(0.0010729039)
    }
  }
}
 */