<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

class UserController extends Controller
{
    /**
     * Will attempt to login a user and send back a JWT token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $token = auth()->attempt($credentials);
        if ($token) {
            return $this->respondWithToken($token);
        } else {
            return response()->json(['error' => "Could not authenticate you"], 403);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required'],
            'password' => ['required']
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'name' => $request->name,
        ]);

        if ($user) {
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['error' => "Could not create the user"], 401);
        }
    }

    /**
     * Will validate if a token is good to use and return the payload if its
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateToken(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $jwt = app(JWT::class);
        $token = $request->get('token');
        $jwt->setToken($token);

        try {
            $payload = $jwt->checkOrFail();
            return response()->json(['status' => 'success', 'payload' => $payload]);
        } catch (JWTException $je) {
            return response()->json(['status' => 'error', 'message' => $je->getMessage()]);

        }
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
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
