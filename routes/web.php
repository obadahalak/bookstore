
<?php

use App\Models\Link;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Api\AuthorController;
use Symfony\Component\Routing\Annotation\Route as test;
use Laravel\SerializableClosure\Support\ReflectionClosure;


Route::get('/download', function () {
    
   $book=Link::Where('token',request()->token)->where('active',true)->first();
    if($book){
        
        $book->update([
            'active'=>false,
        ]);   
      return   Storage::disk('public')->download('/books/1.pdf');
}



});