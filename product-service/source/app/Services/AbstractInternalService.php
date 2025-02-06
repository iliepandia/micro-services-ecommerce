<?php

namespace App\Services;

use GuzzleHttp\Client;

class AbstractInternalService
{
    protected string $endPoint = '';

    protected Client $client;

    public function __construct()
    {
        $this->client = $this->buildClient();
    }


    protected function getAuthHeaders(): array
    {
        return [
            'X-Internal-Auth' => config('app.api_inside_docker_secret'),
            'Accept' => 'application/json'
        ];
    }

    protected function buildClient(): Client
    {
        return new Client([
            'base_uri' => $this->endPoint,
            'headers' => $this->getAuthHeaders(),
            'timeout' => 30,
            'allow_redirects' => false,
        ]);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

}
