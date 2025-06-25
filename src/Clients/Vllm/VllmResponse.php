<?php

namespace Partitech\PhpMistral\Clients\Vllm;

use DateMalformedStringException;
use Partitech\PhpMistral\Clients\Response;

/**
 * Class VllmResponse
 *
 * This class extends the Response class and provides additional functionality
 * for handling updates from an array of data specific to VLLM response handling.
 */
class VllmResponse extends Response
{
    /**
     * Updates the Response object with data provided in the array.
     *
     * If the data contains 'choices', it iterates through them and updates specific
     * fields when certain conditions are met, such as copying data from 'delta.reasoning_content'
     * to 'delta.content' if 'message.content' is not already set.
     *
     * @param self|Response $response The response object to update.
     * @param array $data The data to update the response with.
     *
     * @return Response The updated response object.
     *
     * @throws DateMalformedStringException Throws this exception if the parent
     *                                      method encounters issues related to dates.
     */
    public static function updateFromArray(self|Response $response, array $data): Response
    {
        // Check if the 'choices' key exists in the data array
        if (isset($data['choices'])) {
            // Iterate through each choice in the 'choices' array
            foreach ($data['choices'] as &$choice) {
                // Check if 'reasoning_content' exists in 'delta', it is a string,
                // and 'content' is NOT already set in 'message'
                if (
                    isset($choice['delta']['reasoning_content']) &&
                    is_string($choice['delta']['reasoning_content']) &&
                    !isset($choice['message']['content'])
                ) {
                    // Copy the value from 'delta.reasoning_content' to 'delta.content'
                    $choice['delta']['content'] = $choice['delta']['reasoning_content'];
                }
            }
        }

        // Call the parent updateFromArray method to perform any common updates
        return parent::updateFromArray($response, $data);
    }
}