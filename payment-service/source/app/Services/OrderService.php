<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderService extends AbstractInternalService
{

    protected string $endPoint = "http://order-service:8000";


    /**
     * Gets a string token, calls the user service to validate it if valid returns the payload.
     * @throws GuzzleException
     */
    public function getOrder(int $id) : array
    {
        $client = $this->getClient();

        $response = $client->get("/api/internal/{$id}", ["http_errors" => false ]);

        if($response->getStatusCode() != 200 ){
            throw new ModelNotFoundException("Could not find order with id {$id}. ".
                "Code was: {$response->getStatusCode()}");
        }

        return json_decode($response->getBody()->getContents(), true);
    }

}
