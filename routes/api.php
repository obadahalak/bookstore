<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\RateBookController;
use  App\Http\Controllers\Api\bookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\AuthorBookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryBookController;
use App\Http\Controllers\Api\DownloadBookController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RestPasswordController;
use App\Http\Controllers\Api\WishListBooksController;

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
   
  
    Route::controller(ProfileController::class)->prefix('profile')->middleware('role:author,user')->group(function(){
        Route::get('/', 'index');

        Route::post('/update-user', 'update')->name('update');

        
    Route::controller(RestPasswordController::class)->group(function(){

        Route::get('/forget-Password','index')->name('forgetPassword');
        Route::post('/change-password','update')->name('verifyCode');
    });

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
