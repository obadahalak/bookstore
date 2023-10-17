<?php

namespace App\Http\Controllers\Api;

use App\Events\StoreBookEvent;
use App\Events\TrackingUserActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Services\BookService;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function __construct(private BookService $bookService)
    {
    }

    public function store(BookRequest $request)
    {

        $book = $this->bookService->createBook($request);

        StoreBookEvent::dispatch(auth()->user());

        return response()->data('Your book has been submitted to the admin successfully. Wait for it to be activated ', 201);
    }

   
    public function show(Book $book)
    {
        
        $book = Book::Active()->with(['images'])->find($book->id);
        
        $similarBooks = $this->bookService->similarBooks($book->category_id)->toArray();
        
        event(new TrackingUserActivity($book->id));

        return response()->data(data: BookResource::make($book)->additional($similarBooks));
    }

    public function bestRating()
    {
        return response()->paginate(
            BookResource::collection(
                Book::Active()->with(['coverImage', 'images'])->orderBy('rating', 'desc')->paginate(4)
            ),true);
    }
}
