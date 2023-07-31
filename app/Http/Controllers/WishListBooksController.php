<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Services\BookService;
use App\Http\Resources\BookResource;

class WishListBooksController extends Controller
{
    
    
    public function store(BookRequest $request ){
        $likeOrUnlike=$request->status ? 'syncWithoutDetaching' : 'detach';
         auth()->user()->likes()->$likeOrUnlike([$request->book_id]);
         return response()->json(['message'=>'Successfully']);
    }

    public function index(){
        
        $data=BookResource::collection(Book::with('images')->whereIn('id',BookService::getUserWishlist())->paginate(10));
              
       return response()->paginate($data);
    }
}
