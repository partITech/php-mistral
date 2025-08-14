<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\Exceptions\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);


try {
    $firstRows = $client->rows(dataset: 'nvidia/OpenCodeReasoning', split: 'split_0', config: 'split_0', offset: 3,  length: 2);
    print_r($firstRows);
} catch (MistralClientException $e) {
    print_r($e);
}



/*
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

So X = (count_4[L-1] + count_7[R] ) - L + 2.

So for X to be valid, X must be between 1 and R-L+1, inclusive.

So substituting:

1 ≤ X ≤ R-L+1.

But X is expressed in terms of L and R. So for a given L and R, we can compute X. Then check if X is in the allowed range, and also check if the original condition holds (since this equation is derived from the condition, but perhaps X could be such that L+X-2 is beyond the allowed indices. Wait no, because X is part of the substring, so X can be up to R-L+1. So L+X-2 can be up to L + (R-L+1) -2 = R -1. Which is within the substring's prefix (since the substring is L..R, so up to R-1).

Wait, the prefix is T[1..X-1], which is S[L..L+X-2], because T is the substring S[L..R]. So for X to be 1, X-1 is 0, so the prefix is empty. For X being M, the prefix is up to M-1, which is R- L+1 -1 = R - L. So S[L..R-1].

So for each (L, R), compute X as (count_4[L-1] + count_7[R]) - L + 2. Then check if X is in 1 <= X <= M (where M = R-L+1). If yes, then check if the original condition holds (the number of 4s in the prefix equals the number of 7s in the suffix). But since the equation was derived from the condition, perhaps if X is in the valid range, then the condition holds. So perhaps once X is in the valid range, then (L, R) is counted as a valid substring.

Wait, but how?

Because when we derived X from the equation, that equation must hold. So if X is in the valid range, then the equation holds, which is equivalent to the original condition. So perhaps for each (L, R), if the computed X is in the valid range, then the substring is balanced.

But why?

Let me think again. Suppose we have a substring L..R, and compute X as (count_4[L-1] + count_7[R] ) - L + 2. Then X must be in 1 <= X <= R-L+1. Then substituting into the equation L + X -2 = count_4[L-1] + count_7[R], which came from the original condition. So if X is valid (in the range), then the equation holds, which implies the original condition. Therefore, (L, R) is a balanced substring.

So the algorithm becomes: for each possible substring (L, R), compute X using the formula. Check if X is in [1, M], where M=R-L+1. If yes, then count this substring.

So the problem reduces to finding all (L, R) pairs where X (as computed) is in the valid range. But how do we compute this efficiently?

But even this approach would require checking O(n^2) substrings, which is not feasible for n=1e5. So we need a way to compute the number of (L, R) pairs such that X is in the valid range.

Alternatively, perhaps we can find for each possible X (in the entire string) and see which (L, R) pairs have a split at X.

Wait, maybe there's a way to model this with some mathematical expressions and precompute the counts.

Let me try to model X as (count_4[L-1] + count_7[R]) - L + 2. We need X to be between 1 and M, which is (R-L+1).

So substituting M:

1 <= X <= R-L+1.

But X = (count_4[L-1] + count_7[R]) - L + 2.

So:

1 <= (count_4[L-1] + count_7[R]) - L + 2 <= R - L +1.

Let me subtract 2 from all parts:

-1 <= (count_4[L-1] + count_7[R]) - L <= R - L -1.

Rearranging:

(count_4[L-1] + count_7[R]) - L >= -1.

and

(count_4[L-1] + count_7[R]) - L <= R - L -1.

The second inequality can be rewritten as:

count_4[L-1] + count_7[R] <= R - L -1 + L = R -1.

So:

count_4[L-1] + count_7[R] <= R -1.

But I'm not sure if that's helpful.

Alternatively, perhaps we can express X in terms of L and R.

Another approach: For a given L, can we find all R such that when we compute X, it is within the required range for (L, R)?

But how?

Alternatively, for a fixed X (the split point in the substring), perhaps we can find L and R that satisfy certain conditions.

Alternatively, perhaps we can model the problem by considering that for each possible split point in the original string (i.e., each position k between 1 and N), find all substrings that include k as the X-th position in their own substring. But I'm not sure.

Alternatively, let's think of the split in the substring T (L..R) as being at position X. Then, the split in the original string would be at position L + X -1. Let's denote this position as K = L + X -1.

For the condition to hold, the number of 4s in S[L..K-1] (the prefix of T) must equal the number of 7s in S[K..R] (the suffix of T).

Let me denote:

A = number of 4s in S[L..K-1] = count_4[K-1] - count_4[L-1]

B = number of 7s in S[K..R] = count_7[R] - count_7[K-1]

So A = B.

So we have:

count_4[K-1] - count_4[L-1] = count_7[R] - count_7[K-1]

Rearranged:

count_4[K-1] + count_7[K-1] = count_4[L-1] + count_7[R]

But as before, count_4[K-1] + count_7[K-1] = (K-1) - since each position is either 4 or 7, the sum of 4s and 7s up to K-1 is K-1.

So K-1 = count_4[L-1] + count_7[R]

So K = count_4[L-1] + count_7[R] + 1.

But K is also equal to L + X -1. Wait, K is the position in the original string where the split occurs. So for a substring starting at L and ending at R, K must be between L and R (since X is between 1 and M=R-L+1, so K ranges from L+0 to L + (M-1) = R).

So substituting K:

L + X -1 = count_4[L-1] + count_7[R] + 1.

Wait, no, previous step:

We have K = count_4[L-1] + count_7[R] + 1.

But K must also be in [L, R], because X is between 1 and M, so K is between L and R.

So, for a given L and R, if there exists a K in [L, R] such that K = count_4[L-1] + count_7[R] + 1, then the substring (L, R) is balanced.

But K has to be between L and R. So for each (L, R), compute K = count_4[L-1] + count_7[R] + 1. If K is between L and R, then (L, R) is a valid substring.

Wait, but this seems like a different approach. Because now, for each (L, R), we can compute K and check if it's in the range [L, R]. If yes, then the substring is balanced.

So the problem reduces to counting the number of pairs (L, R) where L <= R, and K = count_4[L-1] + count_7[R] + 1 is in [L, R].

This seems manageable. Because for each L and R, we can compute K and check if L <= K <= R.

But again, for n=1e5, checking all O(n^2) pairs is impossible. So we need a smarter way.

Let's think of variables. Let's precompute the count_4 and count_7 arrays.

Then, for each possible R, we can iterate through all possible L's such that K = count_4[L-1] + count_7[R] +1 is between L and R.

Alternatively, for each R, find all L's where L <= K <= R, where K = count_4[L-1] + count_7[R] +1.

But even that is O(n^2) if not optimized.

Alternatively, for each R, perhaps we can model the equation K = count_4[L-1] + count_7[R] +1 and find L's such that L <= K <= R.

But K is a function of L and R. Let's see:

We can write K = (count_4[L-1] ) + (count_7[R] +1)

Let's denote for a fixed R, count_7[R] is known. Let C = count_7[R] +1.

Then K = C + count_4[L-1].

But K must be between L and R.

So for fixed R and C, the equation becomes:

L <= C + count_4[L-1] <= R.

But L is the variable here. For each L (from 1 to R), we can compute count_4[L-1], then compute K, and check if it's between L and R.

But even for a fixed R, checking all L is O(R) which is O(n) per R, leading to O(n^2) total time. Not feasible.

Hmm. So we need a way to find, for each R, the number of L's such that:

L <= C + count_4[L-1] <= R, where C is count_7[R] +1.

But how to find such L's efficiently.

Let me reorganize the inequalities.

First, the lower bound: C + count_4[L-1] >= L.

Rearranged: count_4[L-1] >= L - C.

Second, the upper bound: C + count_4[L-1] <= R.

Rearranged: count_4[L-1] <= R - C.

So for a fixed R and C, the L's must satisfy:

L - C <= count_4[L-1] <= R - C.

But L varies from 1 to R. So for each L, compute count_4[L-1] and check if it's within [L - C, R - C].

But how to find all L's such that this is true?

Alternatively, for each R, we can compute C = count_7[R] + 1. Then, for all possible L, we need count_4[L-1] to be in [L - C, R - C], and also L must be <= R.

Wait, but count_4[L-1] can be precomputed. For example, for L=1, count_4[0] is 0. For L=2, count_4[1] is the number of 4s in the first character. So for each R, we can iterate L from 1 to R and check the conditions. But that's O(n^2) again.

We need a smarter way. Let's think of possible data structures or pre-processing.

Suppose we have the count_4 array. For each R, C is known. Then for each L, we need:

count_4[L-1] >= L - C

and

count_4[L-1] <= R - C.

But how to find the number of L's (1 <= L <= R) that satisfy both.

The key observation is that for each R, C is fixed. So for each R, we can compute the range [A, B] where A = L - C and B = R - C, and count_4[L-1] must be between A and B.

But L is part of the variable here. So for each possible L, we can precompute for all R, but that's not helpful.

Alternatively, perhaps for each R, we can model this as:

For L in 1..R, check if count_4[L-1] - (L-1) >= (L - C) - (L-1) = 1 - C.

But I'm not sure.

Alternatively, let's consider that for each L, the value count_4[L-1] is known.

Let me define for each index i (0-based?), the value of count_4[i] which is the number of 4s in the first i characters (assuming 0-based). So for example, count_4[0] is 0 (since there are no characters before 0), count_4[1] is 1 if S[0] is '4', else 0, etc.

Then, for a given R (1-based in the original string?), count_7[R] is the number of 7s up to R. Then C = count_7[R] +1.

Now, for each possible L (1-based), which is in 1..R, the conditions are:

count_4[L-1] >= L - C

count_4[L-1] <= R - C

But L is in 1..R.

So for each R, we need to find the number of L in 1..R where count_4[L-1] is in [L - C, R - C].

But how?

Let me think of this as for each R, we can compute C, then for each possible L in 1..R, check if count_4[L-1] is between (L - C) and (R - C). The number of such L is the contribution to the answer for this R.

So for each R, the total is the sum over L=1 to R of 1 if (count_4[L-1] >= L - C) and (count_4[L-1] <= R - C).

But even this approach is O(n^2), which is not feasible.

We need a way to compute, for each R, the number of L's where count_4[L-1] is in the interval [L-C, R-C], and L is <= R.

But how to model this.

Let's consider that for a fixed C, and R, we can represent the problem as:

For each L in 1..R, check if count_4[L-1] is in [L - C, R - C].

Let me make a substitution. Let D = L - C. Then the condition is count_4[L-1] >= D and count_4[L-1] <= R - C.

But D = L - C → L = D + C.

Since L ranges from 1 to R, D ranges from 1 - C to R - C.

But this substitution might not help.

Alternatively, for each R, the range R - C is fixed. So the upper bound is R - C.

The lower bound is L - C, which depends on L.

But this seems tricky. How can we find all L where count_4[L-1] >= L - C and count_4[L-1] <= (R - C).

Another way: For a given R and C, the upper bound is fixed (R-C). The lower bound for L is L - C. So for count_4[L-1] to be >= L - C → count_4[L-1] + C >= L.

But count_4[L-1] is known. So for each L, this is a condition.

Wait, count_4[L-1] + C >= L → C >= L - count_4[L-1].

But C is count_7[R] + 1, which is fixed for this R.

So for a fixed R, the condition is:

count_4[L-1] >= L - C → C >= L - count_4[L-1].

But C is a constant here. So for each L, compute (L - count_4[L-1]) and check if C >= that value.

Similarly, the upper bound is count_4[L-1] <= R - C → count_4[L-1] + C <= R → which is always true because C is count_7[R] + 1. Since count_4[L-1] + count_7[L-1] = L-1. So count_4[L-1] + C = (L-1 - count_7[L-1]) + (count_7[R] + 1) = L + (count_7[R] - count_7[L-1]).

But how does this relate to R? For L <= R, count_7[R] >= count_7[L-1], so (count_7[R] - count_7[L-1]) >=0. So count_4[L-1] + C = L + (count_7[R] - count_7[L-1]) -1 + 1 → ?

Wait, perhaps this isn't helpful.

Alternative approach: Let's consider that for each possible L, we can precompute count_4[L-1] and compute for all R >= L, whether the condition holds. But this again leads to O(n^2).

Hmm. Maybe there's a way to model this with some mathematical transformations.

Wait, let's think again about the two conditions:

For a fixed R and C = count_7[R] +1:

1. count_4[L-1] >= L - C
2. count_4[L-1] <= R - C

But L can be up to R.

Let me define for each L, the value of count_4[L-1] - L. Let's call this V_L.

Then, condition 1 becomes V_L >= -C.

Condition 2 becomes V_L <= (R - C) - L.

But R is fixed here. Hmm.

Alternatively, condition 1 can be rewritten as:

V_L = count_4[L-1] - L >= -C.

So V_L >= -C.

And condition 2:

count_4[L-1] <= R - C → V_L <= (R - C) - L → V_L + L <= R - C → V_L <= (R - C) - L.

But (R - C) is fixed for a given R. So for each L, this becomes:

V_L <= (R - C) - L.

But I'm not sure.

Another idea: For each possible L, the value of count_4[L-1] is fixed. So for each L, we can precompute count_4[L-1], and then for a given R and C, we can check if L satisfies the conditions.

But again, this is O(n^2).

We need to find for each R, the number of L's (<=R) such that count_4[L-1] is in [L - C, R - C], where C = count_7[R] +1.

But how to compute this for all R efficiently.

Another observation: For a substring (L, R) to be balanced, there must exist an X in 1..M such that the split at X satisfies the condition. But maybe there's a way to model this for each possible split in the entire string.

Alternatively, let's consider that for each position K in the string (1 <= K <= N), we can find all substrings (L, R) where K is the split point (i.e., K = L + X -1, and X is within 1..R-L+1). For each K, the condition is:

count_4[K-1] - count_4[L-1] = count_7[R] - count_7[K-1]

Rearranged:

count_4[K-1] + count_7[K-1] = count_4[L-1] + count_7[R]

But count_4[K-1] + count_7[K-1] = K-1 (since each character is either 4 or 7). So:

K-1 = count_4[L-1] + count_7[R]

So for a given K, L and R must satisfy:

count_4[L-1] + count_7[R] = K-1.

Additionally, K must be between L and R. Because K is the split point in the substring (L..R), so K >= L and K <= R.

So for each K, we need to find the number of pairs (L, R) such that:

1. count_4[L-1] + count_7[R] = K-1.

2. L <= K <= R.

So the problem now is to, for each K, find the number of (L, R) pairs satisfying these two conditions, then sum over all K.

This seems promising. Because for each K, we can precompute all possible L and R pairs that satisfy the equation and the inequalities.

But how?

Let me think. For a fixed K, the equation is count_4[L-1] + count_7[R] = K-1.

We need L <= K <= R.

So for each K, we can iterate over all possible R >= K, and compute the required L based on R. Or vice versa.

Alternatively, for each K, iterate over R >= K, and compute the required count_4[L-1] = (K-1) - count_7[R], then find how many L's <= K such that count_4[L-1] equals that value and L <= K.

Wait, because L must be <= K (since K >= L).

So for a fixed K and R (>= K), the required L-1 is such that count_4[L-1] = (K-1) - count_7[R].

Then, L-1 can be any index from 0 to K-1 (since L <= K → L-1 <= K-1). So for each R >= K, the number of valid L's is the number of L-1's (which are 0-based indices) where count_4[L-1] equals (K-1 - count_7[R]).

But this would require for each K, and each R >= K, to find the frequency of (K-1 - count_7[R]) in the count_4 array up to index K-1 (0-based).

This approach would be O(n^2) in the worst case, but maybe we can preprocess some frequency tables.

For example, for each K, precompute a frequency map of count_4[0...K-1]. Then for each R >= K, compute the target value (K-1 - count_7[R]) and look up how many times this target appears in the count_4 array up to K-1.

But this is O(n^2) time and space, which is not feasible.

But perhaps we can find for each K, the possible R's and for each R, compute the target and use a hash map or a precomputed array.

Alternatively, for each possible value of (count_7[R], K), precompute the number of L's.

Alternatively, let's think of the following steps:

1. Precompute count_4 and count_7 arrays.

2. For each K from 1 to N:

   a. The required equation is count_4[L-1] + count_7[R] = K-1.

   b. For R to be >= K, and L must be <= K.

   c. For each R >= K, compute target = (K-1) - count_7[R].

   d. The number of valid L's is the number of times count_4[L-1] equals target, where L-1 ranges from 0 to K-1-1 (since L-1 <= K-1-1 implies L <= K).

   So for each R >= K, the valid L's are those with count_4[L-1] = target and L-1 <= K-1-1 → L-1 <= K-2 → L <= K-1.

Wait, L must be <= K (since L <= K). So L can be up to K.

Wait, L is the start of the substring, and K must be in [L, R]. So L can be from 1 to K.

So for a fixed K and R >= K:

The valid L's are those where:

count_4[L-1] = (K-1) - count_7[R]

and L <= K.

L-1 can range from 0 to K-1.

So for each K, the count_4 array up to K-1 (0-based) can be preprocessed with a frequency map. For example, for each K, we can have a dictionary that maps the value of count_4[i] (for i up to K-1) to the number of times it occurs.

Then, for each R >= K, the target is (K-1) - count_7[R], and the number of L's is the frequency of that target in the frequency map of K.

The total for K is the sum over R >= K of the frequency of (K-1 - count_7[R]) in the map for K.

But building frequency maps for each K is O(n) per K, which is O(n^2) time and space, which is not feasible.

Alternative idea: For each possible value of target, precompute a prefix sum array that tracks the occurrences of target in the count_4 array up to each position.

For example, for each value x, create an array pos_x, which contains all indices i where count_4[i] == x. Then, for a given K and target x, the number of valid L-1's (which are <= K-1) is the number of elements in pos_x that are <= K-1.

But how to do this efficiently.

Alternatively, for each x, we can keep a sorted list of the indices where count_4[i] == x. Then, for a query x and K, the number of valid L-1's is the number of elements in the list for x that are <= K-1. This can be found via binary search.

This way, for each K and R, we can compute the target x = (K-1) - count_7[R], then find how many times x occurs in count_4 up to position K-1.

So the steps would be:

1. Precompute count_4 and count_7 arrays.

2. For each x, build a sorted list of indices where count_4[i] == x. For example, a dictionary where the key is x and the value is a list of i's (0-based) where count_4[i] equals x.

3. For each K from 1 to N:

   a. For each R >= K:

      i. Compute x = (K-1) - count_7[R]

      ii. Find how many indices i in the list for x where i <= K-1. This is the number of valid L's for this R and K.

      iii. Add this count to the total.

But this is still O(n^2), which is not feasible.

Hmm. But perhaps there's a way to find, for each K, all R >= K where x = (K-1) - count_7[R] exists in the count_4 array up to K-1.

But even so, how to sum over all R >= K.

Alternative approach: For each K, iterate R from K to N, and for each R, compute x = (K-1) - count_7[R], then query how many times x appears in count_4 up to K-1. Sum all these counts.

But for K from 1 to N, and R from K to N, this is O(n^2) time. Not feasible.

So this approach is not efficient enough.

Alternative idea: For each possible R, compute all K <= R such that count_4[L-1] = (K-1) - count_7[R], and L <= K.

But I'm not sure.

Another observation: Since K must be <= R and >= L, perhaps for each R, K can range from L to R. But this again brings us back to the same problem.

Alternatively, perhaps for each R, we can find all possible K in 1..R, and for each K, compute x = (K-1) - count_7[R], and count the number of L's where count_4[L-1] = x and L <= K. Sum over K.

But this is also O(n^2) time.

Hmm. Maybe there's a mathematical way to model this. Let's think about the possible values of K and R.

For a given R, K can be any value from 1 to R. For each K, the required x is (K-1) - count_7[R].

We need to find the number of L's <= K such that count_4[L-1] = x.

So for each R, the total contribution is the sum over K=1 to R of the number of L's <= K where count_4[L-1] = (K-1) - count_7[R].

But even this is O(n^2) operations.

Alternative idea: Let's precompute for each possible x, the positions where count_4[i] = x. Then, for each R and K, compute x = (K-1) - count_7[R], and find the number of i's <= K-1 where count_4[i] = x.

This can be done using a binary search on the list of positions for x.

But even this requires O(n^2) binary searches, which is O(n^2 log n) time, which is too slow for n=1e5.

So, this approach is not feasible.

We need to find a way to find, for each R, all K's such that x = (K-1) - count_7[R] is present in the count_4 array up to K-1.

But I'm stuck here. Let's think of the problem from another angle.

Alternative approach: Let's model the problem in terms of variables.

For a substring (L, R), the condition is that there exists K in [L, R] such that count_4[K-1] - count_4[L-1] = count_7[R] - count_7[K-1].

Rearranged:

count_4[K-1] + count_7[K-1] = count_4[L-1] + count_7[R].

But the left side is K-1. So:

K-1 = count_4[L-1] + count_7[R].

So for a substring (L, R) to be valid, there must exist a K between L and R such that K-1 = count_4[L-1] + count_7[R].

But K must be in [L, R], so:

L <= K <= R → L <= (count_4[L-1] + count_7[R] + 1) <= R.

Rearranged:

L <= count_4[L-1] + count_7[R] + 1 <= R.

But this is the same as:

L - count_4[L-1] -1 <= count_7[R] <= R - count_4[L-1] -1.

But this seems complicated.

But perhaps for each L, we can find the range of R's where this inequality holds.

Let me try to fix L and see for which R's this is true.

For a fixed L, we need R >= K → K = count_4[L-1] + count_7[R] +1.

But R must be >= K → R >= count_4[L-1] + count_7[R] +1.

Hmm, but R and count_7[R] are related, which makes this difficult.

Alternative idea: For each L, let's precompute count_4[L-1] as a value. Let's call this a. Then, for R >= L, we need:

a + count_7[R] +1 >= L → count_7[R] >= L - a -1.

And R >= a + count_7[R] +1 → R - count_7[R] >= a +1.

So for a fixed L and a, the conditions on R are:

count_7[R] >= L - a -1.

and

R - count_7[R] >= a +1.

But how to find such R's.

But for each R, R - count_7[R] is known. Let's denote this as D[R] = R - count_7[R].

So for a fixed L and a, the conditions are:

count_7[R] >= C (where C = L - a -1).

and

D[R] >= a +1.

But D[R] = R - count_7[R] = count_4[R], since count_4[R] + count_7[R] = R.

Wait, because count_4[R] + count_7[R] = R (assuming 0-based index and S is 1-based? Or wait, count_4 is the number of 4s up to position i. For example, for a 1-based string S, count_4[i] is the number of 4s in S[1..i]. So count_4[i] + count_7[i] = i.

So R - count_7[R] = count_4[R].

So D[R] = count_4[R].

So the conditions for R are:

count_7[R] >= C → count_7[R] >= L - a -1.

and

count_4[R] >= a + 1.

But a is count_4[L-1], so a = count_4[L-1].

So the conditions become:

count_7[R] >= L - count_4[L-1] -1.

count_4[R] >= count_4[L-1] + 1.

But how to find R's >= L that satisfy these conditions.

For each L, we can compute C1 = L - count_4[L-1] -1.

And C2 = count_4[L-1] + 1.

Then, for R >= L, we need count_7[R] >= C1 and count_4[R] >= C2.

But how to count the number of R >= L where these two conditions are met.

This seems like a range query problem. If we can precompute for each R the count_7[R] and count_4[R], then for each L, we can query the number of R >= L where count_7[R] >= C1 and count_4[R] >= C2.

But even this requires for each L to perform a query over the range [L, N], which could be O(n) per L, leading to O(n^2) total time.

Which is not feasible.

But perhaps we can preprocess some data structures to allow for efficient range queries.

For example, we can build a 2D prefix sum array where for each R, we store count_4[R] and count_7[R]. Then, for a query [L, N], C1 and C2, we need the number of R >= L where count_7[R] >= C1 and count_4[R] >= C2.

But such a query is not straightforward to answer with standard data structures. Possible options include a segment tree with each node storing a list of (count_4, count_7) for the range, sorted, and then for each query, we can perform a binary search. But this would have a high time complexity.

Alternatively, for each possible R, precompute count_4[R] and count_7[R], and store them in two separate arrays. Then, for a given L, iterate R from L to N and check the conditions. But this is again O(n^2) time.

This seems like a dead end.

Another observation: The problem seems similar to the problem of finding pairs (i, j) where some function of i and j is true. Sometimes these can be solved with inclusion-exclusion or other mathematical tricks.

Let's think again about the initial approach where X must be in [1, M] for the substring (L, R). And X is computed as X = count_4[L-1] + count_7[R] - L + 2.

And the substring is valid if X is in [1, R-L+1].

But substituting M = R-L+1, the condition is 1 <= X <= M.

So substituting X into the inequalities:

1 <= count_4[L-1] + count_7[R] - L + 2 <= R - L +1.

Rearranging:

1 <= (count_4[L-1] - L) + (count_7[R] + 2) <= R - L +1.

But this might not help.

Alternatively, the lower bound:

count_4[L-1] + count_7[R] - L + 2 >= 1 → count_4[L-1] + count_7[R] >= L -1.

The upper bound:

count_4[L-1] + count_7[R] - L + 2 <= R - L +1 → count_4[L-1] + count_7[R] <= R - L +1 + L -2 → count_4[L-1] + count_7[R] <= R -1.

So for a valid substring (L, R), the following must hold:

L-1 <= count_4[L-1] + count_7[R] <= R-1.

But how to count the number of (L, R) pairs that satisfy this.

But this is a different way of looking at the condition. For each (L, R), we need the sum of count_4[L-1] and count_7[R] to be between L-1 and R-1, inclusive.

So the problem reduces to counting the number of pairs (L, R) where 1 <= L <= R <= N, and L-1 <= count_4[L-1] + count_7[R] <= R-1.

This is a new perspective. Let's see if this can be optimized.

Let's precompute the count_4 and count_7 arrays.

Then, for each possible pair (L, R), check if L-1 <= (count_4[L-1] + count_7[R]) <= R-1.

But this is again O(n^2).

But perhaps there's a way to model this as a 2D range query problem. For each L, we can find the number of R >= L such that count_7[R] is between (L-1 - count_4[L-1]) and (R-1 - count_4[L-1]).

But the upper bound here is R-1 - count_4[L-1], which depends on R, making it difficult to model.

Alternative approach: Let's consider that for each L, the lower bound is fixed (L-1 - count_4[L-1]), and the upper bound is R-1 - count_4[L-1]. But as R increases, the upper bound increases as well.

For a fixed L, we need R >= L, and count_7[R] >= (L-1 - count_4[L-1]).

Moreover, count_7[R] <= (R-1 - count_4[L-1]).

But count_7[R] is the number of 7s up to R. So count_7[R] <= R.

So for a fixed L, the valid R's must satisfy:

count_7[R] >= (L-1 - count_4[L-1]) → count_7[R] >= C1 (C1 = L-1 - count_4[L-1])

and

count_7[R] <= (R-1 - count_4[L-1]) → count_7[R] + count_4[L-1] +1 <= R.

But this is equivalent to:

count_4[L-1] + count_7[R] +1 <= R → which is the same as the earlier condition.

But I'm not sure.

Alternatively, for a fixed L, the upper bound on count_7[R] is R-1 - count_4[L-1]. But R is varying. So for each R, this upper bound is R-1 - a (a = count_4[L-1]).

So for each R, we need count_7[R] <= R-1 - a → count_7[R] + a <= R-1.

But a = count_4[L-1], which is a fixed value for the current L.

But count_4[L-1] + count_7[R] <= R-1 → count_4[L-1] <= R-1 - count_7[R] → which is count_4[L-1] <= count_4[R] (because count_4[R] + count_7[R] = R → count_4[R] = R - count_7[R] → R-1 - count_7[R] = count_4[R] -1).

Wait, no. count_4[R] = R - count_7[R], so count_4[R] = R - count_7[R] → R-1 - count_7[R] = count_4[R] -1.

So the condition becomes:

count_4[L-1] <= count_4[R] -1 → count_4[L-1] < count_4[R].

So for a fixed L, the upper bound is count_7[R] <= R-1 - a → which is equivalent to count_4[R] > a.

So the condition for R is:

count_7[R] >= C1 (C1 = L-1 - a)

and

count_4[R] > a.

But how to count R's >= L that satisfy these two conditions.

For each L, the valid R's are those >= L where:

count_7[R] >= C1.

and

count_4[R] > a.

But C1 is L-1 - a, and a is count_4[L-1].

But a = count_4[L-1], so C1 = L-1 - count_4[L-1].

But count_4[L-1] is the number of 4's up to L-1. So L-1 - count_4[L-1] is the number of 7's up to L-1. Because count_4[L-1] + count_7[L-1] = L-1 → count_7[L-1] = L-1 - count_4[L-1].

So C1 = count_7[L-1].

So the conditions for R are:

count_7[R] >= count_7[L-1].

count_4[R] > count_4[L-1].

So for a fixed L, the valid R's are those >= L where count_7[R] is at least count_7[L-1] and count_4[R] is greater than count_4[L-1].

Wait, this is a big insight.

Because:

C1 = L-1 - a = L-1 - count_4[L-1] = count_7[L-1].

So for a fixed L, the valid R's must be >= L and satisfy:

count_7[R] >= count_7[L-1].

count_4[R] > count_4[L-1].

But count_7[R] is non-decreasing, since adding more characters can only increase or keep the same count of 7's. Similarly, count_4[R] is non-decreasing.

Wait, count_4 is the number of 4's up to R, so as R increases, count_4 can either increase by 1 (if the next character is 4) or stay the same (if it's 7). So count_4 is a non-decreasing function.

Similarly, count_7 is also a non-decreasing function.

So for a fixed L, count_7[L-1] is a value. Since count_7 is non-decreasing, for R >= L, count_7[R] >= count_7[L], but count_7[L] >= count_7[L-1] (since L >= L-1). So for R >= L, count_7[R] >= count_7[L-1] is automatically true. Because count_7 is non-decreasing, once R >= L, count_7[R] >= count_7[L-1] (since L >= L-1 +1 is not necessarily true. For example, L=1, R=1: count_7[1] >= count_7[0] (0) is true.)

Wait, count_7 is non-decreasing, so for any R >= L-1, count_7[R] >= count_7[L-1]. So for R >= L, which is >= L-1, count_7[R] >= count_7[L-1]. So the first condition (count_7[R] >= count_7[L-1]) is always satisfied for R >= L.

Thus, the first condition is automatically satisfied. So the only condition is that count_4[R] > count_4[L-1], and R >= L.

So for a fixed L, the valid R's are those R >= L where count_4[R] > count_4[L-1].

But count_4 is a non-decreasing array. So once count_4[R] > count_4[L-1], all R' >= R will also satisfy count_4[R'] > count_4[L-1].

So for each L, the minimal R where count_4[R] > count_4[L-1] is some position, say R0. Then, all R >= R0 will be valid.

Thus, for each L, the number of valid R's is (N - R0 + 1), where R0 is the smallest R >= L such that count_4[R] > count_4[L-1].

If no such R0 exists (i.e., count_4[R] never exceeds count_4[L-1] for R >= L), then there are 0 valid R's.

This is a key insight.

So the problem reduces to for each L, find the minimal R >= L such that count_4[R] > count_4[L-1], and then the number of valid R's is max(0, N - R0 + 1).

But how to compute R0 for each L efficiently.

Since count_4 is a non-decreasing array, for each L, R0 can be found using binary search.

For example, for each L, we can binary search in the range [L, N] to find the first R where count_4[R] > count_4[L-1]. Because count_4 is non-decreasing, the binary search can be applied.

This would allow us to compute R0 in O(log n) per L, leading to O(n log n) time for all L's.

Then, for each L, the number of valid R's is max(0, N - R0 + 1) if R0 exists, else 0.

But how to handle the case where count_4[L-1] is equal to count_4[N]. In that case, there is no R >= L where count_4[R] > count_4[L-1], so the count is 0.

So the algorithm is:

1. Precompute count_4 array.

2. For each L from 1 to N:

   a. a = count_4[L-1].

   b. Find the minimal R >= L where count_4[R] > a. Let's call this R0.

   c. If R0 exists, the number of valid R's is N - R0 + 1.

   d. Sum these counts for all L.

But wait, why is this the case?

Because for each L, the valid R's are those >= L and count_4[R] > a.

Because count_4 is non-decreasing, once R0 is found, all R >= R0 will have count_4[R] > a.

So the number of valid R's is the number of R's from R0 to N.

Which is N - R0 + 1.

But why is this the case?

For example, if R0 is 5 and N is 10, then R can be 5,6,7,8,9,10 → 6 numbers → 10-5+1=6.

Yes.

So this approach would work.

But then, the total number of valid pairs (L, R) is the sum over all L of (N - R0 + 1) if R0 exists.

But why does this approach work? Because we have reduced the problem to the condition that for each L, R must be >= L and count_4[R] > count_4[L-1], which was derived from the original conditions.

But wait, how does this relate to the original problem?

The original problem requires that for a substring (L, R), there exists some X such that the split at X makes the 4s in the prefix equal to the 7s in the suffix. We derived that this is equivalent to the sum count_4[L-1] + count_7[R] = K-1, where K is in [L, R]. Then, after multiple steps, we found that the problem reduces to counting pairs (L, R) where count_4[R] > count_4[L-1], and R >= L.

But why is that?

Ah, because when count_4[R] > count_4[L-1], it implies that there exists K in [L, R] such that K-1 = count_4[L-1] + count_7[R], and K is in [L, R].

But I'm not sure. So let's re-verify.

Wait, the previous steps led us to the conclusion that for a pair (L, R) to be valid, the sum count_4[L-1] + count_7[R] must be between L-1 and R-1, and R >= L.

But under the assumption that count_4 is non-decreasing and count_7 is non-decreasing, the first condition count_7[R] >= count_7[L-1] is always true. So the remaining condition is count_4[L-1] + count_7[R] <= R-1.

But how does this relate to count_4[R] > count_4[L-1]?

Because count_4[L-1] + count_7[R] <= R-1.

But count_7[R] = R - count_4[R], since count_4[R] + count_7[R] = R.

So substituting:

count_4[L-1] + (R - count_4[R]) <= R-1.

Rearranged:

count_4[L-1] - count_4[R] <= -1 → count_4[R] >= count_4[L-1] + 1.

So count_4[R] > count_4[L-1].

Ah! So the condition count_4[L-1] + count_7[R] <= R-1 is equivalent to count_4[R] > count_4[L-1].

Thus, the valid pairs (L, R) are those where R >= L and count_4[R] > count_4[L-1].

So the entire problem reduces to counting the number of pairs (L, R) with L <= R and count_4[R] > count_4[L-1].

This is a huge simplification.

So the solution is to count the number of pairs (L, R) where L <= R and count_4[R] > count_4[L-1].

This is a much easier problem.

Because count_4 is a non-decreasing array, since each character is either a 4 or 7. Adding a 4 increases count_4 by 1, adding a 7 leaves it the same. So count_4 is a non-decreasing array.

Thus, for each L, the R's >= L where count_4[R] > count_4[L-1] form a contiguous range from R0 to N.

Thus, for each L, the number of valid R's is N - R0 + 1, where R0 is the smallest index >= L where count_4[R0] > count_4[L-1].

If no such R0 exists (count_4 remains <= count_4[L-1] for all R >= L), then the count is 0.

So the algorithm becomes:

For each L in 1..N:

- Find the smallest R >= L where count_4[R] > count_4[L-1].

- If such R exists, add (N - R + 1) to the answer.

This is correct because for each such R, all R' >= R will also satisfy count_4[R'] > count_4[L-1].

Now, how to compute R0 efficiently.

Since count_4 is non-decreasing, for each L, we can perform a binary search on the range [L, N] to find the first R where count_4[R] > count_4[L-1].

This will take O(log n) per L, leading to O(n log n) time for all L's.

So, the steps are:

1. Precompute the count_4 array.

2. For each L from 1 to N:

   a. a = count_4[L-1]

   b. Binary search in count_4 from index L to N to find the smallest R where count_4[R] > a.

   c. If found, add (N - R + 1) to the answer.

   d. Else, add 0.

This approach should work.

Let's test this against the sample inputs.

Sample Input 1:

4
47
74
477
4747477

Sample Output:

2
2
3
23

Let's take the first test case: input is "47".

The string is "4", "7".

count_4 array (0-based):

count_4[0] = 1 (since first character is 4)

count_4[1] = 1 (second is 7, so count remains 1)

For L=1:

count_4[L-1] = count_4[0] = 1.

Find R >=1 where count_4[R] > 1.

The count_4 array from index 1 to 1 is [1]. No elements >1. So no valid R's.

So contribution is 0.

For L=2:

count_4[L-1] = count_4[1] = 1.

Find R >=2 (which is 2). count_4[2-1] = count_4[1] = 1. So no R >=2 where count_4[R] >1. So contribution is 0.

Wait, but according to the sample output, the first test case's answer is 2. But according to this approach, the answer would be 0. So something is wrong.

Wait, this suggests a mistake in the reasoning.

Ah! What's wrong here.

Wait, the sample input 47 has output 2. The valid substrings are (1,1) and (1,2). So according to the approach, we need to see why these are counted.

Let's see for the first test case:

S = '47' → indexes 1 and 2 (1-based).

count_4 is computed as:

count_4[0] = 0 (since S is 1-based)

count_4[1] = 1 (S[1] is '4').

count_4[2] = 1 (S[2] is '7').

So for L=1:

count_4[L-1] = count_4[0] = 0.

We need to find R >=1 where count_4[R] > 0.

In the count_4 array from R=1 to 2:

count_4[1] =1 >0 → yes. So R0 is 1.

So contribution is N - R0 +1 = 2 -1 +1 = 2.

So for L=1, we add 2.

For L=2:

count_4[1] =1. We look for R >=2 where count_4[R] >1. count_4[2] is 1, which is not >1. So contribution is 0.

Total is 2 +0 = 2, which matches the sample.

Ah, so the mistake was in the way the count_4 array is built. The count_4 array is 0-based, where count_4[0] is 0 (number of 4s up to 0 characters), count_4[1] is the number of 4s in S[1], count_4[2] is the number of 4s in S[1..2], etc.

So in the previous example, for L=1, L-1 is 0, so count_4[0] is 0.

Thus, the algorithm is correct.

This explains why the first test case works.

Another sample: input '74', output is 2.

The string is '7', '4'.

count_4 array:

count_4[0] =0

count_4[1] =0 (first character is 7)

count_4[2] =1 (second character is4)

For L=1:

count_4[0] =0. We look for R >=1 where count_4[R] >0. The first such R is 2. So contribution is 2-2 +1=1.

But wait, R0 is 2, so contribution is 2-2+1=1 (since N=2).

So for L=1, the contribution is 1.

For L=2:

count_4[1] =0. Look for R >=2 where count_4[R] >0. R=2 has count_4=1>0. So contribution is 2-2+1=1.

Total is 1+1=2, which matches the sample.

So the approach works.

Thus, the algorithm is correct.

Now, the code.

The code needs to:

For each test case:

- Precompute count_4 array (0-based, length n+1), where count_4[i] is the number of 4s in the first i characters (assuming 1-based string).

Wait, S is 1-based. So for a string of length n, count_4[0] =0.

count_4[i] = count_4[i-1] + (1 if S[i] == '4' else 0).

Then, for each L in 1..n:

a = count_4[L-1]

We need to find the minimal R >= L such that count_4[R] > a.

If found, add (n - R +1) to the answer.

Thus, the code can be structured as follows:

Read T test cases.

For each test case:

   s = input string.

   n = len(s)

   count_4 = [0]*(n+1)

   for i in range(1, n+1):

      count_4[i] = count_4[i-1] + (1 if s[i-1] == '4' else 0)

   ans =0

   for L in range(1, n+1):

      a = count_4[L-1]

      # binary search for the smallest R >= L where count_4[R] > a.

      # the search is in the range [L, n]

      low = L

      high = n

      res = None

      while low <= high:

          mid = (low + high) // 2

          if count_4[mid] > a:

              res = mid

              high = mid -1

          else:

              low = mid +1

      if res is not None:

          ans += (n - res +1)

   print(ans)

This should work.

Testing this code on the first sample:

Test case 1: '47'

count_4 is [0, 1, 1].

L=1:

a = count_4[0] =0.

We search for R>=1 where count_4[R] >0.

In the array, count_4[1]=1>0. So mid is 1, which is found.

res=1. ans += (2-1+1) =2.

L=2:

a=count_4[1]=1.

Search R>=2 (n=2). count_4[2]=1, which is not >1. So no res. ans +=0.

Total is 2. Correct.

Test case 2: '74' → '7','4'.

count_4 is [0,0,1].

L=1:

a=0.

Search R>=1: count_4[1]=0 <=0 → search higher. mid=1.5→2.

count_4[2] =1>0 → res=2. ans += (2-2+1)=1.

L=2:

a=0 (count_4[1] =0).

search R>=2: count_4[2]=1>0 → res=2. ans +=1.

Total is 2. Correct.

Another sample input: '477' → output is3.

Let's see:

S is '4','7','7'.

count_4 is [0,1,1,1].

L=1:

a=0. Find R >=1 where count_4[R] >0.

The earliest is R=1. ans += 3-1+1=3.

L=2:

a=1. Find R >=2 where count_4[R]>1. But count_4[2]=1, count_4[3]=1. So no such R. contribution 0.

L=3:

a=1. Find R >=3. count_4[3]=1. No. contribution 0.

L=4? No, L ranges up to n=3.

Wait, for n=3, L ranges from 1 to 3.

Wait, L=1:

a=0. R0=1. Contribution 3-1+1=3.

But sample output is 3. So why?

Sample input '477' has output 3. According to the code, it would give 3 (from L=1) plus others?

Wait, wait. Let's re-calculate:

Test case 3: input is '477'.

The code's count_4 array is:

indexes 0,1,2,3.

count_4[0] =0.

count_4[1] =1 (s[0] is '4').

count_4[2] =1 (s[1] is '7').

count_4[3] =1 (s[2] is '7').

L=1:

a=0. search R >=1:

count_4[1] =1>0 → R0=1. contribution 3-1+1=3.

L=2:

a=count_4[1] =1. Search R >=2. count_4[2] =1, count_4[3]=1. So no R where count_4[R] >1. contribution 0.

L=3:

a=count_4[2] =1. Search R >=3. count_4[3] =1 → no. contribution 0.

Total ans=3. Which matches the sample.

Yes.

So the code works for this case.

The fourth test case is more complex, but the code should handle it.

Thus, the code is correct.
</think>

```python
import bisect

def count_balanced_substrings(s):
    n = len(s)
    count_4 = [0] * (n + 1)
    for i in range(1, n+1):
        count_4[i] = count_4[i-1] + (1 if s[i-1] == '4' else 0)
    ans = 0
    for L in range(1, n+1):
        a = count_4[L-1]
        # Binary search for the smallest R >= L where count_4[R] > a
        # The count_4 array is non-decreasing, so we can use bisect
        # We need to search in the subarray count_4[L..n]
        # Using bisect_right to find the first element > a
        R = bisect.bisect_right(count_4, a, lo=L, hi=n+1)
        if R <= n:
            ans += (n - R + 1)
    return ans

T = int(input())
for _ in range(T):
    s = input().strip()
    print(count_balanced_substrings(s))
```
                            [source] => codechef
                            [license] => cc-by-4.0
                            [dataset] => code_contests
                            [split] => train
                            [difficulty] => interview
                            [solution] => import bisect

def count_balanced_substrings(s):
    n = len(s)
    count_4 = [0] * (n + 1)
    for i in range(1, n+1):
        count_4[i] = count_4[i-1] + (1 if s[i-1] == '4' else 0)
    ans = 0
    for L in range(1, n+1):
        a = count_4[L-1]
        # Binary search for the smallest R >= L where count_4[R] > a
        # The count_4 array is non-decreasing, so we can use bisect
        # We need to search in the subarray count_4[L..n]
        # Using bisect_right to find the first element > a
        R = bisect.bisect_right(count_4, a, lo=L, hi=n+1)
        if R <= n:
            ans += (n - R + 1)
    return ans

T = int(input())
for _ in range(T):
    s = input().strip()
    print(count_balanced_substrings(s))
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [1] => Array
                (
                    [row_idx] => 4
                    [row] => Array
                        (
                            [id] => 06aaff0ac61dca6506122cd03fa73ab0
                            [input] => Given a string s. Can you make it a palindrome by deleting exactly one character? Note that size of the string after deletion would be one less than it was before.
Input
First line of the input contains a single integer T denoting number of test cases.
For each test case, you are given a single line containing string  s.

Output
For each test case, print YES or NO depending on the answer of the problem.

Constraints

 Example
Input:
4
aaa
abc
abdbca
abba

Output:
YES
NO
YES
YES

Explanation
Example case 1. Delete any one 'a', resulting string is "aa" which is a palindrome.
Example case 2. It is not possible to delete exactly one character and having a palindrome.
Example case 3. Delete 'c', resulting string is "abdba" which is a palindrome.
Example case 4. Delete 'b', resulting string is "aba" which is a palindrome.
                            [output] => <think>
Okay, I need to solve this problem where I have to determine if a given string can become a palindrome by deleting exactly one character. Let's think about how to approach this.

First, I remember that a palindrome reads the same forwards and backwards. So the basic idea is that if the string is already a palindrome, but maybe even then we need to check if removing one character (which would be possible, but wait, the original string's length might be even or odd. For example, if the original string is a palindrome and has even length, then removing one character would make it odd, but maybe not a palindrome. Wait, no. Wait, the problem says to delete exactly one character, and then check if the resulting string is a palindrome. So even if the original is a palindrome, if after deleting any one character, it's no longer a palindrome, then the answer would be no. Wait, but in the sample input, the fourth test case is "abba", which is a palindrome. The output is YES. Because deleting one 'b' gives "aba", which is also a palindrome. So even if the original is a palindrome, but the length is even, like 4, after deleting one character, it's 3. So "abba" becomes "aba" when you delete the second 'b', which is a palindrome. So in that case, the answer is yes.

Wait, but how to handle the case when the original string is a palindrome. For example, if the original string is "aaa", then deleting any one 'a' gives "aa", which is a palindrome. So output is YES.

So the approach is: For each test case, check if there exists a position i such that by deleting the character at position i, the resulting string is a palindrome.

But checking this for every possible position (each character deletion) might be O(n^2) for each test case, which should be acceptable given the constraints, but maybe there's a smarter way.

The constraints weren't given in the problem statement, but assuming that the string can be up to, say, 1e5 characters, then O(n^2) would be too slow. However, in programming competition problems, such a solution might not pass for large n. But the sample input includes a case like "abdbca" which is length 6, but perhaps the problem expects that the solution is efficient enough for the given test cases.

Alternatively, maybe there's a way to use a two-pointer approach to check in linear time with possible one divergence.

Here's an idea: The standard way to check for a possible palindrome with at most one deletion is to use a helper function that checks if the substring is a palindrome, allowing one skip. So, we can have a helper function that takes two pointers, left and right, and allows one skip. When a mismatch is found, we check two possibilities: skip the left character or skip the right character, and see if either leads to a valid palindrome.

Wait, but how does this apply to the problem here? The problem requires exactly one deletion, not at most one. So if the original string is already a palindrome, then we need to delete exactly one character, and the resulting string must be a palindrome. So, for example, "abba" is a palindrome. If we delete one 'b', then "aba" is still a palindrome. But if the original string is a palindrome with even length, then perhaps deleting the middle two characters (if even) would still leave a palindrome. Wait, but for even length, like "abba", deleting any one character would result in a string of odd length. For example, deleting the first 'a' gives 'bba', which is not a palindrome. So the answer for "abba" is yes because there exists a position to delete (like the second 'b') that leaves a palindrome.

So the problem is not about allowing at most one deletion, but exactly one. So the approach is: For the given string, check if there exists exactly one character to delete such that the resulting string is a palindrome.

But how to efficiently check this?

The two-pointer approach can be modified. Let me think:

We can have a helper function that checks if the substring s[left:right+1] is a palindrome. If not, then we can try deleting either the left or right character and see if either of the resulting substrings is a palindrome.

But since we need to check after exactly one deletion, maybe we can first check if the original string is a palindrome. If it is, then we need to see if after deleting any one character, the resulting string is a palindrome. But for a palindrome of even length, deleting a character in the first half may result in a palindrome. For example, 'abba' becomes 'aba' if you delete the second 'b'. However, for a palindrome of length 4, after deletion of one character, the string is length 3. The middle character can be anything. For example, in 'aba', the first and third characters are the same. So if the original string is a palindrome, then we can delete the middle character (if odd length) and get another palindrome, but for even length, maybe it's possible.

Wait, no. For example, 'abba' is even length. If I delete the first 'b', the string becomes 'ab a' (wait, 'abba' deleting index 1 (the second character) gives 'aba', which is a palindrome. So in that case, yes. So for a palindrome string, if its length is even, then deleting any of the middle two characters (like the first 'b' in 'abba') would leave a palindrome. Wait, no. Let me see:

Original: a b b a (indices 0,1,2,3). Delete index 1: a b a (indices 0,2,3?) Wait, no, the string becomes 'aba' (since after deleting index 1, the characters are a, b, a). So that's a palindrome. So for even-length palindromes, there's at least one way to delete a character to get another palindrome.

But what if the original string is a palindrome of even length? Then, the answer is yes. Wait, let's see. Take 'aaaa' (length 4). Deleting any 'a' would leave 'aaa', which is a palindrome. So yes. So if the original string is a palindrome, then regardless of even or odd length, there exists a way to delete exactly one character and have a palindrome.

Wait, but take 'aba' (length 3). Original is a palindrome. Deleting the middle 'b' gives 'aa' which is a palindrome. So yes. So for any original palindrome, the answer is yes. So the case where the original is a palindrome automatically returns yes.

Wait, but in the sample input, the first test case is 'aaa', which is a palindrome, and the output is yes. Fourth test case 'abba' is a palindrome and output is yes.

But wait, if the original string is a palindrome and its length is 1, then after deleting one character, the string is empty, which is a palindrome. So in that case, the answer is yes. But the problem constraints say that after deletion the size is one less. So for a string of length 1, after deletion, length 0. So the empty string is a palindrome. So that's allowed. So, for the original string being a palindrome, regardless of length, the answer is yes.

But that's not correct. Wait, for example, the string 'a' (length 1). Delete the only character. The resulting string is empty, which is a palindrome. So output is yes.

Another example: 'aa' (length 2). Delete any 'a' to get 'a', which is a palindrome. So yes.

So, in general, if the original string is a palindrome, then the answer is yes. Because you can delete the middle character (for odd length) or any of the middle two (for even) to get a palindrome.

Wait, but this is only if the original string's length is at least 2. Because for a single character, deleting it gives an empty string, which is a palindrome.

So if the original string is a palindrome, then the answer is YES, except when the original string is of length 1. Because then, after deleting one character, it's empty, which is a palindrome. So even then, it's YES.

So for all original palindromes, the answer is YES. Because deleting exactly one character would leave a palindrome. So the answer is YES.

Wait, but what about a palindrome of length 3 where the middle character is different? Wait, no. If it's a palindrome, the first and third characters are the same. For example, 'aba' is a palindrome. Deleting the middle 'b' gives 'aa', which is a palindrome. So yes.

So, the first step is to check if the original string is a palindrome. If it is, then the answer is YES.

But wait, the sample input 4 is 'abba' which is a palindrome, and the output is YES. So that's correct.

But then why the sample input 3 is 'abdbca' (which is not a palindrome) and the output is YES. So the original string isn't a palindrome. So in that case, we need to check if there's a position to delete that would make it a palindrome.

So the approach would be:

For each test case, first check if the original string is a palindrome. If yes, then output YES.

If not, then check whether there exists exactly one character to delete (so, after deletion, the string is a palindrome).

But how?

So the problem is not about the original string being a palindrome. Because even if it's not, we can delete a character and make it a palindrome.

So the plan is:

Check if the original string is a palindrome. If yes, output YES.

Else, check for all possible positions where deleting that character makes the string a palindrome. If any such position exists, output YES, else NO.

But checking each possible position (n positions) and for each, checking if the resulting string is a palindrome (O(n) per check) would be O(n^2) time. For n up to say 1e5, this is not feasible, but perhaps the problem's constraints are small.

But in the sample input, for example, 'abc' is length 3. The original is not a palindrome. Deleting any of the three characters:

Delete 'a' → 'bc' → not palindrome.

Delete 'b' → 'ac' → not.

Delete 'c' → 'ab' → not. So output is NO.

So the code for each test case would be:

For the given string s:

1. Check if s is a palindrome. If yes, return YES.

2. Else, for each i in 0 to len(s)-1:

   a. Create a new string by deleting the i-th character.

   b. Check if that new string is a palindrome.

   c. If any such string is a palindrome, return YES.

3. If none found, return NO.

But this approach could be O(n^2) time. For example, if the string is 1e4 characters, then 1e8 operations, which is probably too slow.

But perhaps in practice, the test cases are small. However, given that the sample input includes 'abdbca' which is length 6, but for larger cases, this approach may not be efficient enough.

So we need a more efficient approach.

The standard way to handle this is to use a helper function that allows checking if the string can be made a palindrome by skipping up to one character. Then, in that process, we can track whether exactly one character was skipped.

Wait, but the problem requires exactly one deletion. So if the original string is not a palindrome, but can be made into a palindrome by deleting exactly one character.

But the helper function for the 'valid palindrome II' problem (Leetcode) allows us to skip one character, either left or right. So in that case, the code can be modified to check that exactly one character is deleted.

Wait, perhaps the approach is to find the first position where the characters don't match, then try skipping the left character and check if the rest is a palindrome. Or try skipping the right character and check. If either is a palindrome, then return YES. But in this approach, the number of deletions is one. Because the original string is not a palindrome, so at least one deletion is needed, and the code checks if one deletion is sufficient.

Wait, but for the problem in Leetcode (valid palindrome II), the problem is to check if the string can be made into a palindrome by deleting at most one character. So in that case, even if the original is a palindrome, it's considered valid. But in our problem, the original being a palindrome is also a valid case (since deleting exactly one character and getting a palindrome). So perhaps the approach is:

Check if the original is a palindrome → if yes, return YES.

Else, check using the helper function (allowing one deletion) → if returns true, then return YES. Else, NO.

But how does the helper function work?

The helper function would check whether the string can be made into a palindrome by deleting at most one character. So, for the problem, the answer is YES if either the original is a palindrome (so deleting any one character would leave a palindrome, but the original must be a palindrome. Wait, no. For example, the original is a palindrome, but after deleting a character, it's not. But the problem requires that after exactly one deletion, the string is a palindrome. So for example, if the original string is 'abba', deleting the first 'a' gives 'bba', which is not a palindrome. But deleting the second 'b' gives 'aba', which is a palindrome. So even though the original is a palindrome, we have to check if there exists at least one character to delete that leaves a palindrome.

So the initial approach of checking if the original is a palindrome, then checking if any of the possible deletions leads to a palindrome is correct, but for large strings, this approach is O(n^2), which is not efficient.

So perhaps a better approach is to:

Check if the original is a palindrome. If yes, return YES.

Else, find the positions where the first mismatch occurs when checking from left and right. Then, check the two possibilities: delete left character or delete right character, and see if either of the resulting substrings is a palindrome.

This is the approach used in the valid palindrome II problem.

Let me think about this.

For example, in the string 'abdbca':

Check left and right pointers:

Start at left=0 (a), right=5 (a). They match. Move left and right inward.

Left=1 (b), right=4 (c). Mismatch. So we need to check two possibilities:

Delete left character (b) and check if the substring from left+1 to right (d, b, c, a) → 'dbca' → but wait, that's not correct. Wait, the current pointers are left=1, right=4. So the characters are s[1] = 'b' and s[4] = 'c' (since the original string is 'a','b','d','b','c','a'). So after deleting left (index 1), the new string would be 'a d b c a' → 'ad bc a' → 'adbc a' (assuming the string becomes 'adbc a', which is 'adbca' (length 5). Checking if this is a palindrome.

Wait, 'a' at start, 'a' at end. Then 'd' vs 'c' next. So no. Not a palindrome.

Alternatively, delete the right character (index 4, which is 'c'), so the string becomes 'abdb a' (since the original is 'a','b','d','b','c','a' → deleting index 4 gives 'abdb a' → 'abdba', which is a palindrome. So this would be a valid case.

So the helper function would find that deleting the right character (index 4) gives a palindrome, so return True.

So the approach is:

Find the first mismatch between left and right pointers.

Check if deleting the left or right character would result in a palindrome.

If either is possible, return YES.

But how to implement this.

So code steps for each test case:

1. Check if the original string is a palindrome. If yes, output YES.

   Wait, no. Because even if the original is a palindrome, we have to delete exactly one character. For example, the original is 'abba'. The code would check if the original is a palindrome (yes), but then need to check if there's a way to delete a character and get a palindrome. But according to the sample input, 'abba' is a yes. But according to the helper function approach, which checks for up to one deletion, the helper function would return yes. But in this case, the original is a palindrome, so the helper function would return true, which would indicate that the answer is yes. But according to the helper function logic, it allows up to one deletion. But in this case, the original is a palindrome, so the helper function would return true (since 0 deletions are allowed).

But the problem requires exactly one deletion. So the helper function approach is not directly applicable.

So the approach has two cases:

Case 1: The original string is a palindrome. Then, we need to check if there exists at least one character to delete such that the resulting string is a palindrome.

Case 2: The original string is not a palindrome. Then, check if there exists exactly one character to delete to make it a palindrome.

So combining these cases.

But how to handle case 1 efficiently.

For case 1, the original is a palindrome. So we need to check if after deleting any one character, the remaining string is a palindrome.

But for a palindrome of length n, after deleting any character, the resulting string's palindrome status depends on which character is deleted.

For example, in 'abba', deleting the first 'a' gives 'bba' which is not a palindrome, but deleting the first 'b' gives 'aba' which is a palindrome.

So in case 1, even though the original is a palindrome, we have to check if there's at least one character whose deletion leaves a palindrome.

But how to check this efficiently.

One approach is: For a palindrome, the minimal way is to delete the first character and check if the resulting string is a palindrome. If yes, then return yes. Otherwise, delete the last character and check. If either is a palindrome, then return yes. If not, then return no.

But this is not sufficient. For example, consider the string 'abcba'. If you delete the middle 'c', you get 'abba', which is a palindrome. But if you delete the first 'a', you get 'bcba', which is not a palindrome. Deleting the first 'b' gives 'acba', which is not a palindrome. So the code that deletes first and last and checks would not find the valid case.

So this approach is not sufficient.

So, for case 1, when the original is a palindrome, we have to check whether there exists any position where deleting that character leaves a palindrome. But for large n, this is O(n^2), which is not efficient.

Alternatively, perhaps in a palindrome, deleting any character except the first half's characters (for even length) or the middle (for odd) would result in a non-palindrome. So perhaps for a palindrome of length >=2, the answer is always yes. Because for example, in a palindrome of even length, deleting the first character may not leave a palindrome, but deleting the middle character (for even length, maybe the middle two?) would. Wait, 'abba' is even. Deleting the middle two characters (indexes 1 and 2) gives 'aa' which is a palindrome. But if you delete index 1, the string becomes 'aba', which is a palindrome. So in this case, the answer is yes.

But what about a palindrome of even length 4, 'aaaa' → deleting any 'a' gives 'aaa', which is a palindrome. So yes.

What about a palindrome of even length 2, 'aa' → deleting either gives 'a', which is a palindrome.

So perhaps for a palindrome of even length, deleting either of the two middle characters would result in a palindrome.

For a palindrome of odd length >=3, like 'aba', deleting the middle 'b' gives 'aa' which is a palindrome. Deleting the first 'a' gives 'ba', which is not. So the answer is yes.

So in general, if the original string is a palindrome, then there exists at least one character to delete to make it a palindrome. So the answer is YES.

Wait, but let's think of a palindrome that is of length 5: 'abcba'. Deleting the middle 'c' gives 'abba', which is a palindrome. So yes.

Another example: 'abbba' (length 5). Deleting the middle 'b' gives 'abba' (palindrome). So yes.

So, for any palindrome of length >=2, the answer is YES. Because, for even length, there are two middle characters (like in 'abba', the two 'b's). Deleting either would leave a palindrome. For odd length, deleting the middle character would leave a palindrome.

So, if the original string is a palindrome, then the answer is YES, provided that the original length is at least 2. But if the original length is 1, then deleting the only character leaves an empty string, which is a palindrome. So even in that case, the answer is YES.

So, in all cases where the original string is a palindrome, the answer is YES.

So the code can be optimized as follows:

For each test case:

1. Check if the original string is a palindrome. If yes, output YES.

2. Else, check if there exists a single character to delete (either by skipping left or right in the first mismatch) such that the resulting string is a palindrome. If yes, output YES. Else, NO.

So the code would first check if the original is a palindrome. If not, then use the helper function to check for the possibility of deleting exactly one character.

So, the steps:

For a given string s:

if is_palindrome(s):

   return YES

else:

   check if by deleting one character (either left or right in the first mismatch), the resulting string is a palindrome. If any of the two possibilities is a palindrome, return YES, else NO.

But how to implement the helper function.

The helper function would be similar to the one in Leetcode's valid palindrome II problem.

Here's the code outline:

def is_palindrome(s):

   return s == s[::-1]

def can_form_palindrome(s):

   left = 0

   right = len(s) -1

   while left < right:

       if s[left] == s[right]:

           left +=1

           right -=1

       else:

           # check two possibilities: delete left or delete right

           # check delete left: s[left+1 ... right]

           # check delete right: s[left ... right-1]

           return is_palindrome(s[left+1: right+1]) or is_palindrome(s[left: right])

   return True

Wait, but this function is for the case where we can delete at most one character. So, if the original string is a palindrome, this function returns True. But in our case, we have to first check if the original is a palindrome (which would return YES), else check if the helper function returns True.

So combining this, the code would be:

for each test case s:

   if is_palindrome(s):

       print("YES")

   else:

       if can_form_palindrome(s):

           print("YES")

       else:

           print("NO")

But wait, the can_form_palindrome function returns True even if the original is a palindrome. But in our code, we have already checked for that, so it's not a problem.

But how does the can_form_palindrome function work when the original is not a palindrome. It checks if by deleting one character (left or right in the first mismatch), the resulting string is a palindrome.

So, for example, in the string 'abdbca', which is not a palindrome. The helper function would find the first mismatch at positions 1 and 4 (characters 'b' and 'c'). Then it checks deleting left (i=1) → substring from 2 to 5 (s[2:5+1] → 'dbca') → which is 'dbca' → is it a palindrome? 'd' vs 'a' → no. Then check deleting right (i=4) → substring from 1 to 4 → s[1:4] → 'bdbca'? Wait, no. Wait, the code is s[left:right], which for left=1 and right=4 (original right is 4). So s[1:4] would be s[1], s[2], s[3], which is 'b', 'd', 'b'. So the substring 'bdb'. Wait, wait the original string is 'abdbca' → indexes 0:a, 1:b, 2:d, 3:b,4:c,5:a.

In the helper function, when left=1 and right=4 (s[1]=b, s[4]=c), the code would check s[left+1:right+1] (left+1=2, right+1=5 → s[2:5] is d, b, c → 'dbc'? No. Wait, in Python, s[a:b] is from index a up to but not including b. So s[2:5] is characters at 2,3,4 → 'd', 'b', 'c' → 'dbc', which is not a palindrome. Then check s[left:right] → s[1:4] → indexes 1,2,3 → 'b', 'd', 'b' → which is 'bdb', a palindrome. So the helper function would return True.

So in this case, the helper function returns True, so the code outputs YES.

So the helper function works for this case.

Another example: 'abc' → the helper function would find the first mismatch at left=0 (a) and right=2 (c). Then check s[1:3] (bc) → not palindrome. Check s[0:2] (ab) → not palindrome. So helper function returns False → code outputs NO.

So this works.

So the code would be:

Read T test cases.

For each s:

if s is a palindrome → YES

else:

   check if deleting one character (via helper) can make it a palindrome → if yes, YES else NO.

But what about cases where the original is not a palindrome, but there are multiple mismatches and deleting a character that is not in the first pair?

For example, the string 'abccdba' → suppose after the first mismatch, the helper function tries deleting the left or right, but the actual solution is to delete a character further along.

But the helper function would only check the first pair of mismatched characters and try deleting left or right. So this could miss some cases.

For example, consider the string 'abcde fgdcba' → wait, maybe this is not a good example. Let's think of a string where the first mismatch can be fixed by deleting either left or right, but after that, there's another mismatch that can't be fixed. Or perhaps a case where the first mismatch's deletion possibilities are not correct, but a later deletion is needed.

For example, the string 'aabcdbaa' → let's see:

The string is 'a', 'a', 'b', 'c', 'd', 'b', 'a', 'a'.

Check from left and right:

left=0 (a), right=7 (a) → match.

left=1 (a), right=6 (a) → match.

left=2 (b), right=5 (b) → match.

left=3 (c), right=4 (d) → mismatch.

So the helper function would check deleting left (c) → s becomes 'aabddbaa' (since we delete index 3, the string is 'aabddbaa'? Wait, original string is 'a a b c d b a a' → indexes 0-7. Deleting index 3 (c), the string becomes 'aab d b a a' → 'aabdb aa'? Then check if this is a palindrome. The new string is 'aabdb aa' → which is 'a a b d b a a' → length 7. Check left and right:

left=0, right=6 (a and a → match.

left=1, right=5 (a and a → match.

left=2 (b), right=4 (d → mismatch. So the helper function would return False for this path.

Alternatively, delete the right character (d, index 4). The new string is 'a a b c b a a' → 'aabcb aa' → which is 'a a b c b a a'. Check:

left=0 and 6 (a, a → match.

left=1 and 5 (a and a → match.

left=2 and 4 (b and b → match.

left=3 (c), left=3, right=3. So it's a palindrome. So the helper function returns True.

So the code would return YES.

But in this example, the helper function's approach of checking only the first mismatch and deleting left or right worked.

But what about a case where the first mismatch can't be fixed by deleting left or right, but a later deletion could fix it.

For example, the string 'abbaac'.

Original string is 'a', 'b', 'b', 'a', 'a', 'c'. The original is not a palindrome.

Check left=0 (a) and right=5 (c). Mismatch.

So helper function would check deleting left (a) → 'bbaa c' → 'bbaa c' → 'bbaac' (since after deleting index 0, the string is 'bbaa c' → 'bbaac' which is 'b b a a c'. Check if this is a palindrome: left 0 (b) and right 4 (c → mismatch. So not a palindrome.

Then check deleting right (c), the string becomes 'abbaa'. Check if it's a palindrome. 'abbaa' → length 5. Check left=0 (a) and right=4 (a → match. left=1 (b) and right=3 (a → mismatch. So not a palindrome. So helper function returns False.

But the actual correct deletion is to delete the last 'c' and the second 'a' in the middle. Wait, no. Wait, the string is 'abbaac'. The correct deletion would be to delete the 'c' to make 'abbaa', which is not a palindrome. So perhaps there's no solution.

But then the code would return NO. But what if there's a case where the first deletion is not the correct one but a later deletion is needed?

For example, 'cabac'. Original string is not a palindrome. First mismatch is c vs c (left 0 and right 4). Wait, no. Let me see:

Original string: c a b a c. It is a palindrome. So code returns YES.

Another example: 'caba'. Original is not a palindrome. Check first mismatch: left 0 (c) and right 3 (a). Delete left (c) → 'aba' → palindrome. So helper function returns True.

But what if the string is 'cbaab' → not a palindrome. Let's see:

Left=0 (c) and right=4 (b). Mismatch. So delete left (c → 'baab' → which is a palindrome. So helper function returns True.

So in this case, the code works.

But what if the first mismatch is at positions 0 and 4, and deleting either gives a non-palindrome, but there's a deletion elsewhere that would work.

For example: 'abcdedcbaa' → original string is a palindrome? Let's see: a b c d e d c b a a. No. The first a and last a are same. Next b and a → no. So first mismatch is at positions 1 (b) and 9 (a). So helper function tries deleting left (b) → check s[2:9+1] → substring from 2 to 10 (since Python slicing is up to but not including end. So original string is length 10, indexes 0-9.

So deleting left (index 1) → the substring is s[2:10] → 'cdedcbaa'.

Check if this is a palindrome. 'c d e d c b a a' → first c and last a: no. So not a palindrome.

Delete right (index 9, a) → substring is s[0:9] → 'abcdedcba', which is a palindrome. So helper function returns True.

So code returns YES.

So even though there are multiple mismatches, the helper function's approach of checking the first pair and trying to delete either left or right works.

Thus, the helper function's approach is sufficient.

Thus, the code can be written as:

Check if the original is a palindrome → if yes, return YES.

Else, use the helper function to see if after deleting one character (left or right in the first mismatch) results in a palindrome.

Thus, the code is as follows:

Read T test cases.

For each test case:

s = input().strip()

if s == s[::-1]:

    print("YES")

else:

    left = 0

    right = len(s) - 1

    while left < right:

        if s[left] == s[right]:

            left +=1

            right -=1

        else:

            # check delete left or right

            s1 = s[left+1:right+1]  # after deleting left

            s2 = s[left:right]      # after deleting right

            if s1 == s1[::-1] or s2 == s2[::-1]:

                print("YES")

            else:

                print("NO")

            break

    else:

        print("YES")

Wait, but what if the loop completes without breaking (the else clause of the while loop). This can only happen if the loop condition is not met, i.e., left >= right. Which would imply that all characters matched, so the original is a palindrome. But we have already checked that before entering the else block. So this part of the code is unreachable.

So the code can be:

for each test case:

    s = input().strip()

    if s == s[::-1]:

        print("YES")

    else:

        left = 0

        right = len(s) -1

        found = False

        while left < right:

            if s[left] == s[right]:

                left +=1

                right -=1

            else:

                # check two options

                s1 = s[left+1: right+1]

                s2 = s[left: right]

                if s1 == s1[::-1] or s2 == s2[::-1]:

                    print("YES")

                else:

                    print("NO")

                found = True

                break

        if not found:

            print("YES")

But since the original string is not a palindrome, the loop must have found a mismatch, so the 'found' would be set to True, and the code would have printed YES or NO.

Thus, the code is correct.

But wait, in the case where the original is not a palindrome, the loop will break at the first mismatch, check s1 and s2, and print YES or NO.

So, this code should handle all cases.

Testing the sample input:

Sample Input 4:

4

aaa → is a palindrome → print YES.

abc → not a palindrome. Mismatch at a and c. Check s1 (bc) and s2 (ab). Neither is palindrome → print NO.

abdbca → not a palindrome. Mismatch at b and c. Check s1 (d,b,c,a) → s[left+1:right+1] is s[2:5+1] → indexes 2-5 (d, b, c, a) → 'dbca' → no. s2 is s[1:4] → 'bdb c' → no. Wait, wait, the original string is 'abdbca' → indexes 0:a,1:b,2:d,3:b,4:c,5:a. So left is 1, right is 4. So s1 = s[2:5] (since right+1 is 5 → indexes 2,3,4 → d, b, c → 'dbc' which is not a palindrome. s2 is s[1:4] → indexes 1,2,3 → b, d, b → 'bdb' which is a palindrome. So the code would print YES.

Fourth test case: abba → is a palindrome → print YES.

Which matches the sample output.

Another test case: 'abba' → code outputs YES.

Another test case: 'a' → is a palindrome → YES.

Another test case: 'aa' → YES.

Another test case: 'ab' → not a palindrome. Check s1 (b) → palindrome. So output YES. Wait, no. 'ab' → after deleting 'a', we get 'b' → palindrome. So code should output YES.

Wait, but according to the code:

s = 'ab'. It is not a palindrome.

In the loop:

left=0, right=1. s[0] = 'a', s[1] = 'b' → mismatch.

s1 is s[1:2] → 'b' → palindrome. So code prints YES.

So for input 'ab', output is YES.

But according to the problem statement, the sample input 'abba' is YES because deleting one 'b' gives 'aba'. But according to the code, 'ab' would return YES. But according to the problem statement, the answer depends on whether the resulting string is a palindrome after exactly one deletion.

So for 'ab', the code is correct.

Thus, the code is correct.
</think>

```python
def is_palindrome(s):
    return s == s[::-1]

T = int(input())
for _ in range(T):
    s = input().strip()
    if is_palindrome(s):
        print("YES")
        continue
    left = 0
    right = len(s) - 1
    found = False
    while left < right:
        if s[left] == s[right]:
            left += 1
            right -= 1
        else:
            # Check two possibilities: delete left or delete right
            s1 = s[left+1 : right+1]  # Delete left character
            s2 = s[left : right]      # Delete right character
            if is_palindrome(s1) or is_palindrome(s2):
                print("YES")
            else:
                print("NO")
            found = True
            break
    if not found:
        print("YES")
```
                            [source] => codechef
                            [license] => cc-by-4.0
                            [dataset] => code_contests
                            [split] => train
                            [difficulty] => 2
                            [solution] => def is_palindrome(s):
    return s == s[::-1]

T = int(input())
for _ in range(T):
    s = input().strip()
    if is_palindrome(s):
        print("YES")
        continue
    left = 0
    right = len(s) - 1
    found = False
    while left < right:
        if s[left] == s[right]:
            left += 1
            right -= 1
        else:
            # Check two possibilities: delete left or delete right
            s1 = s[left+1 : right+1]  # Delete left character
            s2 = s[left : right]      # Delete right character
            if is_palindrome(s1) or is_palindrome(s2):
                print("YES")
            else:
                print("NO")
            found = True
            break
    if not found:
        print("YES")
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
*/