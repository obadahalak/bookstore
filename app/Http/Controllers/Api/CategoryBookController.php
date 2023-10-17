<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Category;

class CategoryBookController extends Controller
{
    public function show(Category $category)
    {

        $books = Book::with(['user', 'category', 'coverImage', 'bookFile', 'likes'])

            ->Active()->where('category_id', $category->id)->paginate(10);

        return response()->paginate(BookResource::collection($books), true);
    }

    public function index()
    {

        $category = Category::query();

        $category->with(['books' => fn ($q) => $q->latest()->limit(3)]);

        request()->whenHas('search', function () use ($category) {

            $category->whereHas('books', function ($query) {
                return  $query->where('name', 'LIKE', '%' . request()->search . '%');
            });
        });


        return response()->paginate($category->paginate(5), true);
    }

    public function books(Category $category)
    {

        $books = $category->books()
        
        ->with(['category', 'user', 'coverImage', 'bookFile', 'likes'])
        
        ->paginate();

        return response()->data(
            data: BookResource::collection($books)
        );
    }
}
