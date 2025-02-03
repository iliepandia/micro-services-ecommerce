<?php

namespace App\Http\Middleware;


class InternalServiceAuth
{

    /**
     * Makes sure we trust each other and the API gateway
     * @param $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, \Closure $next) {
        if (!$request->hasHeader('X-Internal-Auth') ||
            $request->header('X-Internal-Auth') !== config('app.api_gateway_secret')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}
