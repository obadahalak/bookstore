<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Events\Evaluated;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;

class RateBookController extends Controller
{
    public function store(BookRequest $request){
      
        auth()->user()->evaluations()->syncWithoutDetaching([$request->book_id=>['value'=>$request->value]]);
        
        Evaluated::dispatch($request->book_id);
     
        return response()->data('Evaluation successfully',201);
     
     }

     public function index()
     {
        $books=BookResource::collection(
            Book::Active()->with(['coverImage', 'images'])
            ->orderBy('rating', 'desc')->paginate(4));
        return response()->data($books);
    }
}
