<?php

namespace App\Http\Middleware;


class RequireJsonHeaders
{

    /**
     * Makes sure we trust each other and the API gateway
     * @param $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, \Closure $next) {
        if(!$request->hasHeader("Accept") || $request->header("Accept") != 'application/json'){
            return response()->json(['error' => 'Missing required `Accept: application/json` header'], 400);
        }
        return $next($request);
    }
}
