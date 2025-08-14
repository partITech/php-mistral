<?php

namespace Tests\Functional\Clients\LLaMaCpp;

use Throwable;

/**
 * Functional test for the Tokenize and Detokenize features of the LlamaCppClient.
 * This test ensures that the tokenize and detokenize methods behave as expected.
 */
class TokenizeDetokenizeTest extends Setup
{
    /**
     * Tests the tokenize and detokenize endpoints to ensure the process
     * correctly transforms a text prompt into tokens and back to the original text.
     *
     * @return void
     */
    public function testTokenizeAndDetokenize(): void
    {
        // The text prompt to be tokenized and detokenized
        $prompt = 'What are the ingredients that make up dijon mayonnaise?';

        try {
            // --- Tokenization Process ---
            // Call the client's tokenize method to transform the prompt into tokens
            $tokens = $this->client->tokenize(prompt: $prompt);

            // Validate that the returned tokens object is not null
            $this->assertNotNull($tokens, 'The tokenize response should not be null.');

            // Ensure the response is an object
            $this->assertIsObject($tokens, 'The tokenize response should be an object.');

            // Validate that tokens exist in the response
            $this->assertNotEmpty($tokens->getTokens(), 'The tokenize response should contain tokens.');

            // Convert tokens to an array for further inspection
            $tokenArray = $tokens->getTokens()->getArrayCopy();

            // Ensure the resulting tokens are in array form
            $this->assertIsArray($tokenArray, 'The tokens should be an array.');

            // Validate that the tokens array is not empty
            $this->assertGreaterThan(0, count($tokenArray), 'The tokens array should not be empty.');

            // Verify that each token is a valid non-negative integer
            foreach ($tokenArray as $token) {
                $this->assertIsInt($token, 'Each token should be an integer.');
                $this->assertGreaterThanOrEqual(0, $token, 'Each token should be a non-negative integer.');
            }

            // --- Detokenization Process ---
            // Call the client's detokenize method to convert tokens back into text
            $detokenizedResult = $this->client->detokenize(tokens: $tokenArray);

            // Validate that the detokenized response is not null
            $this->assertNotNull($detokenizedResult, 'The detokenize response should not be null.');

            // Ensure the response is an object
            $this->assertIsObject($detokenizedResult, 'The detokenize response should be an object.');

            // Verify that the detokenized text matches the original prompt
            $this->assertEquals(
                $prompt,
                $detokenizedResult->getPrompt(),
                'The detokenized text should match the original prompt.'
            );
        } catch (Throwable $e) {
            // Fail the test if any exception is thrown during the process
            $this->fail('Tokenize or Detokenize request failed with error: ' . $e->getMessage());
        }
    }
}