<?php

use Illuminate\Support\Facades\Route;

Route::middleware(\App\Http\Middleware\InternalServiceAuth::class)->group(function(){
    Route::get('/', function () {
        return view('welcome');
    });
});
