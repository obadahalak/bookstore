<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {

        $books = Book::with(['category', 'user', 'coverImage', 'bookFile', 'likes']);
        $homePage= [
            'NEW BOOKS' => BookResource::collection($books->latest()->take(4)->get()),
            'TOP RATING' => BookResource::collection($books->orderby('rating')->take(4)->get()),
        ];
        return response()->data(data:$homePage,cache:true);
    }
}
