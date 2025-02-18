<?php

use App\Http\Controllers\PaymentController;
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
        Route::get("list", [PaymentController::class, 'list'])->name('payment.list');
        Route::get("/{id}", [PaymentController::class, 'payment'])->name('payment.get');
        Route::post("/create", [PaymentController::class, 'create'])->name('payment.create');
    });
});
