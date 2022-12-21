<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;



Route::controller(AuthController::class)->group(function(){


    Route::get('/login','authUser');
    Route::post('/user','createUser');
});
