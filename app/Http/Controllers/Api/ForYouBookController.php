<?php

namespace App\Http\Controllers\Api;


use App\Models\Book;
use App\Models\Category;
use App\traits\foryouService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\UserActivity;

class ForYouBookController extends Controller
{
    use foryouService;
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {

        $books = [];
        if (auth()->check()) {

            $categories = $this->getCategoirsFromWishList();
        }

        if (!count($categories)) {
            $categories = Category::inRandomOrder()->take(5)->get('id')->pluck('id')->toArray();
        }

        $categories = $this->sortingIds($categories);

        $books = Category::whereIn('id', $categories)
           
            ->with(['books' => function ($q) {
            
                $q->whereNotIn('books.id',auth()->user()->withlistBooksid())
            
                ->with(['user', 'category', 'coverImage', 'bookFile', 'likes'])
            
                ->latest()->limit(3);
            
            }])->get()->pluck('books');

        return  BookResource::collection($books->flatMap(function ($book) {
            return $book;
        }));
    }
}
