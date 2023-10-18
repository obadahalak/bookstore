<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RestPasswordController;
use App\Http\Controllers\Api\AuthorBookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BooksSchedulingController;
use App\Http\Controllers\Api\CategoryBookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DownloadBookController;
use App\Http\Controllers\Api\ForYouBookController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\RateBookController;
use App\Http\Controllers\Api\WishListBooksController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

////configuration ///
Route::get('setup', function () {

    return Artisan::call('storage:link');
});



////authentication endpoints ///
Route::controller(AuthController::class)->name('user.')->prefix('auth')->group(function () {

    Route::post('sign-in', 'login')->name('login');
    Route::post('sign-up', 'store')->name('register');

    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        Route::get('/', 'index')->middleware('role:author,user');

        Route::post('edit', 'update')->name('update')->middleware('role:author,user');

        Route::controller(RestPasswordController::class)->group(function () {

            Route::get('forget-password', 'index')->name('forgetPassword');
            Route::post('change-password', 'update')->name('verifyCode');
        });
    });
});

/// books endpoints ////
Route::controller(BookController::class)->prefix('books')->as('book.')->group(function () {

    Route::get('seeMore', 'getBooks');

    // Route::get('/', 'index');

    Route::post('/', 'store')->name('store')->middleware('role:author');

    Route::get('{book:id}', 'show')->name('show');

    Route::get('get/bestRating', 'bestRating');

    Route::controller(CategoryBookController::class)->prefix('category')->group(function () {
        Route::get('{category}/books', 'books')->name('f');
        Route::get('/index', 'index');
        Route::get('/{category}', 'show');
    });

    Route::controller(WishListBooksController::class)->middleware('role:user')->prefix('wishlist')->group(function () {

        Route::get('get', 'index');
        Route::post('/', 'store')->name('wishlist');
    });

    Route::controller(BooksSchedulingController::class)->prefix('books_schedulings')->group(function () {

        Route::get('completeSchedule', 'update');
        Route::get('staticses', 'staticses');
        Route::get('get', 'index');
        Route::post('/', 'store');
    });

    Route::controller(AuthorBookController::class)->prefix('author')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(RateBookController::class)->prefix('rate')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store')->name('evaluateBook')->middleware('role:user');
    });
});
Route::controller(DownloadBookController::class)->prefix('download')->group(function () {
    Route::get('check', 'index')->middleware('is_active_link');
    Route::get('{book:id}', 'store');
});
Route::get('foryou', ForYouBookController::class);

///// home page endpoints ////
Route::controller(HomeController::class)->prefix('/homepage')->group(function () {

    Route::get('/', 'index');
});

Route::controller(AuthorController::class)->prefix('authors')->group(function () {
    Route::get('/', 'index');
    Route::get('{user:id}', 'show');
    Route::get('typesOfAuthors', 'types');
});

//  categories endpoints ////
Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/', 'show');
    // Route::post('/', 'store')->middleware('role:author,user');
});
