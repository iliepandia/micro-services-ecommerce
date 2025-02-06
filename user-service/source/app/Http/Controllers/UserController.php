<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Will attempt to login a user and send back a JWT token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function login( Request $request )
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        $token = auth()->attempt($credentials);
        if( $token ){
            return $this->respondWithToken($token);
        }else{
            return response()->json(['error' => "Could not authenticate you"], 403 );
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
