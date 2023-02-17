<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Book;
use App\Models\Category;
use App\Http\Requests\BookRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class bookController extends Controller
{

    public function store(BookRequest $request)
    {


        $book = Book::create([
            'name' => $request->name,
            'details' => $request->details,
            'overview' => $request->overview,
            'auther_id' => $request->auther_id,
            'category_id' => $request->category_id,
            'rating' => 1,
        ]);

        foreach ($request->book_gallery as $image) {

            $bookGalleryPath = $image->store('bookGaller', 'public');
            $book->bookImages()->create([
                'file' => 'public/' . $bookGalleryPath,
                'type' => 'gallary'
            ]);
        }
        $coverPath = $request->book_cover->store('bookCover', 'public');
        $book->coverBook()->create([
            'file' => 'public/' . $coverPath,
            'type' => 'cover'
        ]);

        return response()->json(['book created success'], 201);
    }
    public function books()
    {
        return BookResource::collection(Book::latest()->paginate(10));
    }
    public function book($id)
    {
        return new  BookResource(Book::find($id));
    }
}
