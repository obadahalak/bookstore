<?php
namespace App\Http\Controllers\Api;


use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Cache;

class CategoryBookController extends Controller
{
    public function index(Request $request){
        $books=  Cache::rememberForever("books_by_category_$request->category_id",function() use($request){
            return Book::with(['user','category','coverImage','bookFile','likes'])->Active()->where('category_id',$request->category_id)->paginate(10);

        });
        return response()->data(BookResource::collection($books));
    }
}
