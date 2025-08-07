<?php

namespace Partitech\PhpMistral\Clients\Mistral;

use Partitech\PhpMistral\Exceptions\MaximumRecursionException;
use Partitech\PhpMistral\Exceptions\MistralClientException;

class MistralAgentClient extends MistralClient
{
    /**
     * @throws MistralClientException|MaximumRecursionException
     */
    public function createAgent(MistralAgent $agent): MistralAgent
    {
        $payload = $agent->toArray();

        $response = $this->request(
            method    : 'POST',
            path      : '/v1/agents',
            parameters: $payload
        );

        return MistralAgent::fromArray($response);
    }


    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function getAgent(MistralAgent|string $agent): MistralAgent
    {
        $agentId = $agent instanceof MistralAgent ? $agent->getId() : $agent;

        if (!$agentId) {
            throw new \InvalidArgumentException('Missing agent ID.');
        }

        $response = $this->request(
            method: 'GET',
            path  : "/v1/agents/{$agentId}"
        );

        return MistralAgent::fromArray($response);
    }

    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function updateAgent(MistralAgent $agent): MistralAgent
    {
        $agentId = $agent->getId();

        if (!$agentId) {
            throw new \InvalidArgumentException('Cannot update agent without an ID.');
        }

        $payload = $agent->toArray();

        $response = $this->request(
            method    : 'PATCH',
            path      : "/v1/agents/{$agentId}",
            parameters: $payload
        );

        return MistralAgent::fromArray($response);
    }

    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function updateAgentVersion(MistralAgent|string $agent, int $version): MistralAgent
    {
        $agentId = $agent instanceof MistralAgent ? $agent->getId() : $agent;

        if (!$agentId) {
            throw new \InvalidArgumentException('Missing agent ID.');
        }

        $response = $this->request(
            method: 'PATCH',
            path  : "/v1/agents/{$agentId}/version",
            parameters: [
                'query' => [
                    'version' => $version
                ]
            ]
        );

        return MistralAgent::fromArray($response);
    }

    /**
     * @throws MaximumRecursionException
     * @throws MistralClientException
     */
    public function listAgents(int $page = 0, int $pageSize = 20): array
    {
        $query = [
            'page' => $page,
            'page_size' => $pageSize
        ];

        $response = $this->request(
            method: 'GET',
            path: '/v1/agents?' . http_build_query($query)
        );

        return array_map(
            fn(array $agentData) => MistralAgent::fromArray($agentData),
            $response
        );
    }
}