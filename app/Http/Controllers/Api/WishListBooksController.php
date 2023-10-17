<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Services\BookService;
use App\Models\Book;

class WishListBooksController extends Controller
{
    public function store(BookRequest $request)
    {
        $likeOrUnlike = $request->status ? 'syncWithoutDetaching' : 'detach';
        auth()->user()->likes()->$likeOrUnlike([$request->book_id]);

        return response()->data(message: 'book added to your wishlist', status: 201);
    }

    public function index()
    {

        $books = BookResource::collection(Book::with(['user', 'category', 'coverImage', 'bookFile', 'likes'])->whereIn('id', BookService::getUserWishlist())->paginate(10));

        return response()->paginate(data:$books,cache:true);
    }
}
