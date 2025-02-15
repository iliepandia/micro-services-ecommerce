<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AbstractInternalService
{
    protected string $endPoint = '';

    protected Client $client;

    protected Request $request;

    public function __construct(?Request $request = null)
    {
        $this->request = $request;
        $this->client = $this->buildClient();
        if (!$this->request) {
            $this->request = \request();
        }
    }


    protected function getAuthHeaders(): array
    {
        return [
                'X-Internal-Auth' => config('app.api_inside_docker_secret'),
                'Accept' => 'application/json'] +
            ($this->request->_auth_user_id ? [
                'X-Internal-User-Id' => $this->request->_auth_user_id,
                'X-Internal-User-Roles' => implode(',', $this->request->_auth_user_roles ?? []),
            ] : []);
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
