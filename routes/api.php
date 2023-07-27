<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\WishlistController;
use  App\Http\Controllers\Api\bookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\AuthController;



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
    Route::post('/sendCode','codeCheck')->name('verifyCode');
  
    Route::middleware('role:user')->group(function(){
        Route::get('/profile', 'profile');

        Route::post('/update-user', 'update')->name('update');
    });
    

});



Route::controller(WishlistController::class)->middleware('role:user')->prefix('wishlist')->group(function(){
    Route::get('/', 'Wishlist')->name('wishlist');
               

    Route::post('/add', 'store')->name('wishlist');
                
});
/// books endpoints ////   
Route::controller(bookController::class)->prefix('books')->group(function(){
    Route::get('/seeMore','getBooks');
    Route::get('/','index');
    Route::get('/{book:id}','show')->name('book.show');
    Route::get('/{Author_id}','author_books');
    Route::get('filter','bookByCategoryId')->name('bookByCategory');
    Route::post('create','store')->name('book.store')->middleware('role:author');
    Route::get('bestRating','bestRating');
    Route::get('foryou','foryou');
    Route::post('evaluate','evaluate')->name('evaluateBook')->middleware('role:user');
});



///// home page endpoints ////
Route::controller(HomeController::class)->prefix('/homepage')->group(function () {

    Route::get('/', 'index');

});


Route::controller(AuthorController::class)->prefix('authors')->group(function(){
    Route::get('/typesOfAuthors','types');
    Route::get('/', 'authors');
    Route::get('/find', 'author');
    Route::get('books','books');
    // Route::get('/{user:id}','test');
});

/// categories endpoints ////
Route::controller(CategoryController::class)->prefix('categories')->group(function () {

    Route::get('/', 'categories');  
    Route::post('/create', 'store');    
});
