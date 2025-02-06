<?php

use Illuminate\Support\Facades\Route;

//This is already prefixed with "/api"
Route::middleware([\App\Http\Middleware\InternalServiceAuth::class,\App\Http\Middleware\RequireJsonHeaders::class])->group(function(){
    Route::post("login", [\App\Http\Controllers\UserController::class, 'login']);
});
