<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Events\TrackingUserActivity;
use App\Models\Category;
use App\Events\StoreBookEvent;
use App\Http\Requests\BookRequest;
use App\Http\Services\BookService;
use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;


class bookController extends Controller
{


    public function store(BookRequest $request, BookService $bookService)
    {

        $book = $bookService->createBook($request);

        // Cache::put($book->getCacheKey(), $book, 60);


        StoreBookEvent::dispatch(auth()->user());

        return response()->data('Your book has been submitted to the admin successfully. Wait for it to be activated ', 201);
    }


    public function index()
    {
        $category = Category::query();
        $category->with(['books' => function ($q) {
            $q->limit(3);
        }]);

        if (isset(request()->search)) {

            $category->whereHas('books', function ($query) {
                $query->where('name', 'LIKE', '%' . request()->search . '%');
            });
        }

        return response()->cacheResponsePaginate($category->paginate(5));
    }
    public function getBooks()
    {

        $category = Category::whereId(request()->category_id)->first();


        $books = Book::with(['category', 'user', 'coverImage', 'bookFile', 'likes'])->where('category_id', request()->category_id)
            ->skip(request()->skip)->take(3)
            ->where('name', 'LIKE', '%' . request()->name . '%')
            ->get();

        $isMoreBooks = (request()->skip *= 2) >= $category->books()->count();
        return response()->cacheResponse
        (
            data:BookResource::collection($books),
            args: ['status' => $isMoreBooks],
            status_code: 200,
            message: ''
        );
       ;
    }
    public function show(Book $book)
    {   event( new TrackingUserActivity($book->id));
        return response()->cacheResponse(new BookResource(Book::Active()->with(['images'])->find($book->id)));
    }

    public function bestRating()
    {
        return response()->cacheResponsePaginate(BookResource::collection(Book::Active()->with(['coverImage', 'images'])->orderBy('rating', 'desc')->paginate(4)));
    }                   
}
