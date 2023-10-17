<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Services\BookService;
use App\Models\Book;

class PubluishBooksController extends Controller
{
    public function active(BookRequest $request, BookService $bookService)
    {

        $bookService->active(Book::find($request->book_id), $request->status);
    }
}
