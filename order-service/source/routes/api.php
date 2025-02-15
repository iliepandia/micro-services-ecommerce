<?php

use App\Http\Controllers\OrderController;
use App\Http\Middleware\BearerTokenAuth;
use App\Http\Middleware\InternalServiceAuth;
use App\Http\Middleware\RequireJsonHeaders;
use App\Http\Middleware\RequireUserRole;
use App\Http\Middleware\TrustedUserHeadersAuth;
use Illuminate\Support\Facades\Route;

//This is already prefixed with "/api"
Route::middleware([
    BearerTokenAuth::class,
    InternalServiceAuth::class . ":api_gateway_secret",
    RequireJsonHeaders::class])->group(function () {

    Route::middleware([RequireUserRole::class . ":customer"])->group(function () {
        Route::get("list", [OrderController::class, 'list'])->name('order.list');
        Route::get("/{id}", [OrderController::class, 'order'])->name('order.get');
        Route::post("/create", [OrderController::class, 'create'])->name('order.create');
    });
});

//These are meant to be called only from inside the docker network
Route::middleware([
    InternalServiceAuth::class . ":api_inside_docker_secret",
    TrustedUserHeadersAuth::class,
    RequireJsonHeaders::class])->prefix("internal")->group(function(){
        Route::middleware([RequireUserRole::class . ":customer"])->group(function(){
            Route::get("/{id}", [OrderController::class, 'order'])->name('order.get');
        });
    });
