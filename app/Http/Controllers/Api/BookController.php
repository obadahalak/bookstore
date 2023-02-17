<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class bookController extends Controller
{

    public function books()
    {
        return BookResource::collection(Book::latest()->paginate(10));
    }
    public function book($id)
    {
        return new  BookResource(Book::findOrFail($id));
    }
}
