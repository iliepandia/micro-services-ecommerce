<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;

class UserService extends AbstractInternalService
{

    protected string $endPoint = "http://user-service:8000";


    /**
     * Gets a string token, calls the user service to validate it if valid returns the payload.
     * @throws GuzzleException
     */
    public function decodeToken(string $tokenString ) : array
    {
        $client = $this->getClient();

        $response = $client->post('/api/internal/validate-token', [
            'form_params' => [
                'token' => $tokenString,
            ],
        ]);

        $response = json_decode($response->getBody()->getContents(), true);
        if($response['status'] !== 'success'){
            abort(403, "Could not validate the auth token." );
        }

        return $response['payload'];
    }

}
