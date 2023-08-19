<?php


namespace App\Http\Controllers\Api;


use App\Models\Book;

use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

  public function index()
  {
    $books = Book::with(['category', 'user', 'coverImage', 'bookFile', 'likes']);

    return response()->data(

      [
        'NEW BOOKS' =>
        BookResource::collection($books->latest()->take(4)->get()),
        'TOP RATING' =>
        BookResource::collection($books->orderby('rating')->take(4)->get()),
      ]

    );
  }
}
