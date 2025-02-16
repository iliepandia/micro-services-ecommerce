<?php

use Illuminate\Support\Facades\Route;

Route::middleware(\App\Http\Middleware\InternalServiceAuth::class. ':api_gateway_secret')->group(function(){
    Route::get('/', function () {
        return view('welcome');
    });
});
