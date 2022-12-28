<?php

namespace App\Http\Controllers\Api;

use  App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;

class bookController extends Controller
{

    public function books()
    {
        return BookResource::collection(Book::latest()->paginate(10));
    }
    public function book($id){
        return new  BookResource(Book::find($id));
    }


}
