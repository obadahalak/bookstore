<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use  App\Http\Controllers\Api\bookController;


////configuration ///
Route::get('/seeder', function () {
    Artisan::call('migrate:fresh --seed');
});


Route::get('/clear', function () {
    Artisan::call('optimize:clear');
});


////authentication endpoints ///
Route::controller(AuthController::class)->group(function () {


    Route::get('/login', 'authUser');
    Route::post('/user', 'createUser');

    Route::get('/getUser', 'getUser')->middleware('auth:sanctum');
    Route::post('/update-user', 'updateUser')->name('updateUser')->middleware('auth:sanctum');


    Route::get('/users', 'users');
});

///// home page endpoints ////
Route::controller(HomeController::class)->group(function () {


    Route::get('/homePage','homePage');
   // Route::get('/newBooks', 'newBooks');
    Route::get('/bestRating', 'bestRating');
    Route::get('/authors', 'authors');
});


/// categories endpoints ////
Route::controller(CategoryController::class)->group(function () {


    Route::get('/tags', 'tags');
    Route::get('/categories', 'categories');
    Route::get('/categoriesByTag/{tagId}', 'categoriesByTag');
});


/// books endpoints ////
Route::controller(bookController::class)->group(function () {

    Route::get('/books', 'books');
    Route::get('/book/{id}', 'book');
});
