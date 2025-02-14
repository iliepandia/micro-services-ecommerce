<?php

namespace App\Http\Middleware;


use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class RequireUserRole
{

    /**
     * @param $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws GuzzleException
     */
    public function handle(Request $request, \Closure $next, string $role) {

        $roles = $request->get('_auth_user_roles', [] );

        if( !in_array( $role, $roles)){
            abort(403, "Required role `$role` missing from this user." );
        }

        return $next($request);
    }
}
