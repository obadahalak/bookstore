<?php


use App\Models\Category;
use App\Actions\PayPalMethod;
use Vaites\ApacheTika\Client;
use App\Http\Services\PaymentService;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\AuthorCollection;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\WishlistController;
use  App\Http\Controllers\Api\bookController;
use App\Http\Controllers\Api\AutherController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\AuthController;



////configuration ///
Route::get('/seeder', function () {
    Category::create([
        'title'=>'222',
        'count_of_books'=>0,
    ]);
    // Artisan::call('migrate:fresh --seed');
});


Route::get('/clear', function () {
   
    Artisan::call('optimize:clear');
});


Route::get('/payment', function () {
   $paymentService=new PaymentService(); 
   return $paymentService->payment(new PayPalMethod);
});



////authentication endpoints ///
Route::controller(AuthController::class)->prefix('auth')->group(function () {


    Route::post('/register', 'accountRegister')->name('account');
    Route::get('/login', 'authentection')->name('login');
   
    Route::post('/forgetPassword','sendResetPasswordCode')->name('forgetPassword');
    Route::post('/sendCode','codeCheck')->name('verifyCode');
  
    Route::middleware('role:user')->group(function(){
        Route::get('/profile', 'profile');

        Route::post('/update-user', 'update')->name('updateUser');
    });
    

});



Route::controller(WishlistController::class)->middleware('role:user')->prefix('wishlist')->group(function(){
    Route::get('/', 'Wishlist')->name('wishlist');
               

    Route::post('/add', 'store')->name('wishlist');
                
});
/// books endpoints ////   
Route::controller(bookController::class)->prefix('book')->group(function(){
    Route::get('all','index');
    Route::get('find','show')->name('book.show');
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


Route::controller(AutherController::class)->prefix('author')->group(function(){
    Route::get('/all', 'authors');
    Route::get('/find', 'author');
    Route::get('/{user:id}','test');
});

/// categories endpoints ////
Route::controller(CategoryController::class)->prefix('categories')->group(function () {

    Route::get('/', 'categories');  
    Route::post('/create', 'store');    
});
