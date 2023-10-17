<?php

namespace App\Http\Controllers\Api;

use App\Events\Evaluated;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;

class RateBookController extends Controller
{
    public function store(BookRequest $request)
    {

        auth()->user()->evaluations()->syncWithoutDetaching([$request->book_id => ['value' => $request->value]]);

        Evaluated::dispatch($request->book_id);

        return response()->data('Evaluation successfully', 201);

    }

    public function index()
    {
        $books = BookResource::collection(
            Book::Active()->with(['coverImage', 'images'])
                ->orderBy('rating', 'desc')->paginate(4));

        return response()->data($books);
    }
}
