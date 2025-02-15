<?php

namespace App\Http\Middleware;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

/**
 * Authenticates the user on TRUSTED routes, based on request headers.
 */
class TrustedUserHeadersAuth
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws GuzzleException
     */
    public function handle(Request $request, \Closure $next ) {
        if(!$request->hasHeader('X-Internal-User-Id')){
            abort(403, "Missing required header for trusted routes auth for user id.");
        }
        if(!$request->hasHeader('X-Internal-User-Roles')){
            abort(403, "Missing required header for trusted routes auth for user roles.");
        }
        //This middleware CANNOT be used on public routes, since it implicitly trusts the headers
        // should only
        $request->merge([
            '_auth_user_id' => $request->header('X-Internal-User-Id'),
            '_auth_user_roles' => explode(",", $request->header('X-Internal-User-Roles')),
        ]);

        return $next($request);
    }
}
