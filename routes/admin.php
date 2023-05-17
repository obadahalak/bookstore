<?php



use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\PubluishBooksController;
use Illuminate\Support\Facades\Route;


Route::controller(AdminAuthController::class)->group(function(){
    Route::get('auth','login');
});

Route::middleware(['auth:admin'])->controller(PubluishBooksController::class)->group(function(){

    Route::post('active-book','active')->name('publish');
}); 