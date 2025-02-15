<?php

namespace App\Http\Middleware;


use App\Services\UserService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class BearerTokenAuth
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    protected function getToken( Request $request ) : string
    {
        if(!$request->hasHeader('Authorization')){
            abort(403, "Missing required authorization header");
        }
        $bearer = $request->header('Authorization');
        $bearer = explode(" ", $bearer );
        if(strtolower($bearer[0]) != 'bearer'){
            abort(403, "Authorization must be of bearer type");
        }
        $token = $bearer[1];

        return $token;
    }

    /**
     * @param Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws GuzzleException
     */
    public function handle(Request $request, \Closure $next ) {

        $payload = $this->userService->decodeToken($this->getToken($request));

        $request->merge([
            '_auth_user_id' => $payload['sub'],
            '_auth_user_roles' => $payload['roles']??[],
        ]);

        return $next($request);
    }
}
