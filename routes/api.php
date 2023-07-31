<?php


use App\Models\Book;
use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\RateBookController;
use App\Http\Controllers\WishlistController;
use  App\Http\Controllers\Api\bookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\AuthorBookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\CategoryBookController;
use App\Http\Controllers\DownloadBookController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\WishListBooksController;

////configuration ///
Route::get('/setup', function () {
    
    Artisan::call('migrate:fresh --seed');
});


Route::get('/clear', function () {
   
    Artisan::call('optimize:clear');
});



////authentication endpoints ///
Route::controller(AuthController::class)->name('user.')->prefix('auth')->group(function () {


    Route::post('/sign-up', 'store')->name('register');
    Route::post('/sign-in', 'login')->name('login');
   
    Route::post('/forgetPassword','resetPassword')->name('forgetPassword');
    Route::post('/change-password','updatePassword')->name('verifyCode');
  
    Route::middleware('role:author,user')->group(function(){
        Route::get('/profile', 'profile');

        Route::post('/update-user', 'update')->name('update');
    });
    

});



/// books endpoints ////   
Route::controller(bookController::class)->prefix('books')->as('book.')->group(function(){
    
    Route::get('/','index');
    
    Route::post('/','store')->name('store')->middleware('role:author');
    
    Route::get('/{book:id}','show')->name('show');
   
    Route::get('/seeMore','getBooks');
    
    
    
    Route::controller(WishListBooksController::class)->middleware('role:user')->prefix('wishlist')->group(function(){
        
        Route::get('/', 'index');
        Route::post('/', 'store')->name('wishlist');
                
    });

    Route::controller(CategoryBookController::class)->prefix('category')->group(function(){
        Route::get('/','index');
    });
    
    Route::controller(AuthorBookController::class)->prefix('author')->group(function(){
        Route::get('/','index');
    });

    Route::controller(RateBookController::class)->prefix('rate')->group(function(){
        Route::get('/','index');
        Route::post('/','store')->name('evaluateBook')->middleware('role:user');
    });

    Route::controller(DownloadBookController::class)->prefix('download')->group(function(){
        Route::get('/','index');
        Route::post('/{book:id}','store');
    });

    Route::get('/foryou',ForYouBookController::class);
});



///// home page endpoints ////
Route::controller(HomeController::class)->prefix('/homepage')->group(function () {

    Route::get('/', 'index');

});


Route::controller(AuthorController::class)->prefix('authors')->group(function(){
    Route::get('/', 'index');
    Route::get('/', 'show');
    Route::get('/typesOfAuthors','types');

});

/// categories endpoints ////
Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/', 'categories');  
    Route::post('/create', 'store');    
});
