<?php

use App\Http\Middleware\InternalServiceAuth;
use App\Http\Middleware\RequireJsonHeaders;
use Illuminate\Support\Facades\Route;

//This is already prefixed with "/api"
Route::middleware([InternalServiceAuth::class . ":api_gateway_secret",RequireJsonHeaders::class])->group(function(){
    Route::post("login", [\App\Http\Controllers\UserController::class, 'login']);

    Route::post("register", [\App\Http\Controllers\UserController::class, 'register']);

});


//These are meant to be called only from inside the docker network
Route::middleware([InternalServiceAuth::class . ":api_inside_docker_secret", RequireJsonHeaders::class])
    ->prefix("internal")->group(function(){
    Route::post("validate-token", [\App\Http\Controllers\UserController::class, 'validateToken']);
});
