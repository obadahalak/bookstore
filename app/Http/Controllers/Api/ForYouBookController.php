<?php
namespace App\Http\Controllers\Api;


use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ForYouBookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
            $books=[];
           if(auth()->check()){
         
            $categories=DB::table('likes')
            
                ->where('likes.user_id',auth('user')->id())
                
                ->join('books', 'books.id','=','likes.book_id')
                
                ->selectRaw('books.category_id, COUNT(likes.id) AS num_likes')
                
                ->groupBy('books.category_id')
                
                ->orderBy('num_likes','DESC')
                
                ->pluck('category_id')
                
                ->take(5);
                
            }
          if(!count($categories)){
            $categories = Category::inRandomOrder()->take(5)->get('id')->pluck('id');
        }
            $books=Book::whereIn('category_id',$categories)->paginate(10);
            return response()->data($books);
    
    }
}
