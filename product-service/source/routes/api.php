<?php

use App\Http\Controllers\ProductController;
use App\Http\Middleware\BearerTokenAuth;
use App\Http\Middleware\InternalServiceAuth;
use App\Http\Middleware\RequireJsonHeaders;
use App\Http\Middleware\RequireUserRole;
use Illuminate\Support\Facades\Route;

//This is already prefixed with "/api"
Route::middleware([
    BearerTokenAuth::class,
    InternalServiceAuth::class . ":api_gateway_secret",
    RequireJsonHeaders::class])->group(function () {

    Route::middleware([RequireUserRole::class . ":customer"])->group(function () {
        Route::get("list", [ProductController::class, 'list'])->name('product.list');
        Route::get("/{id}", [ProductController::class, 'product'])->name('product.get');
    });
});


//These are meant to be called only from inside the docker network
Route::middleware([
    InternalServiceAuth::class . ":api_inside_docker_secret",
    RequireJsonHeaders::class])
    ->prefix("internal")->group(function(){
        Route::get("/{id}", [ProductController::class, 'product'])->name('product.get');
});
