## Rows

#### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);


try {
    $firstRows = $client->rows(dataset: 'nvidia/OpenCodeReasoning', split: 'split_0', config: 'split_0', offset: 3,  length: 2);
    print_r($firstRows);
} catch (MistralClientException $e) {
    print_r($e);
}

```


#### Result

```text
Array
(
    [features] => Array
        (
            [0] => Array
                (
                    [feature_idx] => 0
                    [name] => id
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [1] => Array
                (
                    [feature_idx] => 1
                    [name] => input
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [2] => Array
                (
                    [feature_idx] => 2
                    [name] => output
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [3] => Array
                (
                    [feature_idx] => 3
                    [name] => source
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [4] => Array
                (
                    [feature_idx] => 4
                    [name] => license
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [5] => Array
                (
                    [feature_idx] => 5
                    [name] => dataset
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [6] => Array
                (
                    [feature_idx] => 6
                    [name] => split
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [7] => Array
                (
                    [feature_idx] => 7
                    [name] => difficulty
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [8] => Array
                (
                    [feature_idx] => 8
                    [name] => solution
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

        )

    [rows] => Array
        (
            [0] => Array
                (
                    [row_idx] => 3
                    [row] => Array
                        (
                            [id] => e2e75d9d7d47d6f22c7eb408f8911af8
                            [input] => A Little Elephant from the Zoo of Lviv likes lucky strings, i.e., the strings that consist only of the lucky digits 4 and 7.
The Little Elephant calls some string T of the length M balanced if there exists at least one integer X (1 ≤ X ≤ M) such that the number of digits 4 in the substring T[1, X - 1] is equal to the number of digits 7 in the substring T[X, M]. For example, the string S = 7477447 is balanced since S[1, 4] = 7477 has 1 digit 4 and S[5, 7] = 447 has 1 digit 7. On the other hand, one can verify that the string S = 7 is not balanced.
 The Little Elephant has the string S of the length N. He wants to know the number of such pairs of integers (L; R) that 1 ≤ L ≤ R ≤ N and the substring S[L, R]  is balanced. Help him to find this number.
Notes.

Let S be some lucky string. Then


|S| denotes the length of the string S;

S[i] (1 ≤ i ≤ |S|) denotes the i^th character of S (the numeration of characters starts from 1);

 S[L, R] (1 ≤ L ≤ R ≤ |S|) denotes the string with the following sequence of characters: S[L], S[L + 1], ..., S[R], and is called a substring of S. For L > R we mean by S[L, R] an empty string.
Input
The first line of the input file contains a single integer T, the number of test cases. Each of the following T lines contains one string, the string S for the corresponding test case. The input file does not contain any whitespaces.

Output
For each test case output a single line containing the answer for this test case.


Constraints
 1 ≤ T ≤ 10
 1 ≤ |S| ≤ 100000
 S consists only of the lucky digits 4 and 7.



Example

Input:
4
47
74
477
4747477

Output:
2
2
3
23



Explanation
In the first test case balance substrings are S[1, 1] = 4 and S[1, 2] = 47.
In the second test case balance substrings are S[2, 2] = 4 and S[1, 2] = 74.
Unfortunately, we can't provide you with the explanations of the third and the fourth test cases. You should figure it out by yourself. Please, don't ask about this in comments.
                            [output] => <think>
Okay, I need to solve this problem where I have to count the number of balanced substrings in a given string of 4s and 7s. Let's try to understand the problem step by step.

First, the definition of a balanced substring T of length M. It's balanced if there exists an X between 1 and M (inclusive) such that the number of 4s in the prefix T[1 to X-1] is equal to the number of 7s in the suffix T[X to M]. So for example, if the substring is of length 2, like '47', then X could be 1. Because the prefix before X is nothing (so 0 4s), and the suffix from X=1 to 2 is '47' which has one 7. Wait, but 0 vs 1? Oh wait, maybe I'm misunderstanding the example.

Wait the example given in the problem is S=7477447. The balanced substring is when L=1 and R=7. The split is at X=4. So S[1..4] is 7477, which has 1 four (since positions 2 is 4, and positions 1,3,4 are 7,7,7?) Wait wait, no. Wait S is 7 4 7 7 4 4 7. So S[1,4] is 7,4,7,7. The 4s here are 1. Then S[5,7] is 4,4,7. The 7s here are 1. So 1 equals 1, so it's balanced.

So the idea is that for a substring T (which is a part of S), we split it into two parts before X and after (including X). The number of 4s in the prefix (before X) should equal the number of 7s in the suffix (from X to end). And for the substring to be balanced, there must be at least one such X in it.

The problem is to find all possible substrings (L, R) where L <= R, such that in that substring, there exists such an X.

Now, how to approach this efficiently?

The naive approach would be to check all possible substrings (there are O(n^2) of them for a string of length n) and for each substring check all possible X positions (O(n) per substring). But for n=1e5, that's O(n^3) which is impossible.

So we need a smarter way.

Let's think about the conditions. For a substring S[L..R], which is length M = R-L+1. We need to find if there exists an X (1<=X<=M) such that:

number of 4s in S[L..L+X-2] equals the number of 7s in S[L+X-1..R].

Wait, because in the original definition, the substring T is from position 1 to X-1 (which in the original string is from L to L+X-2) and the suffix is X to M (which is L+X-1 to R).

Wait, T is the substring S[L..R]. Let's say the length of T is M = R-L+1. Then X can be from 1 to M. The prefix is T[1..X-1], which is S[L..L+X-2] (since T's positions are 1-based). The suffix is T[X..M], which is S[L+X-1..R].

So for each possible substring (L, R), we need to check if there's any X such that the count of 4s in prefix is equal to the count of 7s in suffix.

But how can we compute this efficiently?

Let's try to model this. Let's denote:

For the substring S[L..R], the total 4s in the entire substring is total_4. The total 7s is total_7 = (R-L+1) - total_4.

But for the split X, the prefix (before X) has A 4s, and the suffix (from X onwards) has B 7s. The condition is A = B.

But the total 4s in the substring is A + (number of 4s in suffix). Because the prefix is up to X-1, and the suffix includes X. So the 4s in the suffix would be total_4 - A. Similarly, the 7s in the suffix would be (total_7) - (number of 7s in the prefix) + (number of 7s in the suffix). Wait, maybe it's easier to model the suffix's 7s.

Wait the suffix from X to M (T's X to M) is S[L+X-1..R]. The number of 7s in the suffix is equal to the total number of 7s in the substring T minus the number of 7s in the prefix (since the prefix is from 1 to X-1, which is S[L..L+X-2], which is part of the substring T).

Wait, maybe for the substring S[L..R], let's precompute the prefix sums of 4s and 7s.

Let me think of the prefix sum arrays for the entire original string. Let's precompute for the entire string S:

- For each position i, count_4[i] is the number of 4s in S[1..i].
Similarly for count_7[i].

Then, for a substring L..R, the total 4s is count_4[R] - count_4[L-1], and similarly for 7s.

For the split X in the substring (which is X in 1..M, where M = R-L+1), the prefix of the substring (positions 1 to X-1) corresponds to S[L..L+X-2]. The number of 4s in this prefix is count_4[L+X-2] - count_4[L-1], but only if L+X-2 >= L. Otherwise, if X-1 is 0, then it's 0.

Similarly, the suffix of the substring is positions X to M, which is S[L+X-1..R]. The number of 7s here is count_7[R] - count_7[L+X-1 - 1] (since L+X-1 is the start of the suffix, so subtract up to L+X-2). So that's count_7[R] - count_7[L+X-1 -1] = count_7[R] - count_7[L+X-2].

So the condition is:

(count_4[L+X-2] - count_4[L-1]) = (count_7[R] - count_7[L+X-2])

We can rearrange this equation:

count_4[L+X-2] - count_4[L-1] = count_7[R] - count_7[L+X-2]

Rearranging terms:

count_4[L+X-2] + count_7[L+X-2] = count_4[L-1] + count_7[R]

But count_4[L+X-2] + count_7[L+X-2] is equal to (L+X-2) because every position is either 4 or 7. So the left side is (L+X-2). The right side is (count_4[L-1] + count_7[R]).

So the equation becomes:

L + X - 2 = count_4[L-1] + count_7[R]

Let's solve for X:

X = count_4[L-1] + count_7[R] - L + 2

But X must be in 1..M, where M = R-L+1.

So substituting M:

X must satisfy 1 ≤ X ≤ R-L+1.

So substituting X into that inequality:

1 ≤ (count_4[L-1] + count_7[R] - L + 2) ≤ R-L+1.

Let me rearrange the equation:

X = (count_4[L-1] + count_7[R] ) - (L - 2)

So X = (count_4[L-1] + count_7[R] ) - L + 2.

Wait, no. Because X is equal to (count_4[L-1] + count_7[R] ) - L + 2?

Wait, let me recheck:

Original equation after rearrangement:

L + X -2 = count_4[L-1] + count_7[R]

So X = (count_4[L-1] + count_7[R]) - L + 2.

Yes.

[...]
)

                    [truncated_cells] => Array
                        (
                        )

                )

        )

    [num_rows_total] => 170361
    [num_rows_per_page] => 100
    [partial] => 1
)
```