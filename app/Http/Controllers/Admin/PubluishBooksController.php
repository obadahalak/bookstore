<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\BookService;

class PubluishBooksController extends Controller
{
    
    public function active(BookRequest $request, BookService $bookService){
        
       $bookService->active(Book::find($request->book_id),$request->status);
    }

}
