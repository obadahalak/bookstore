<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Category;
use App\Events\Evaluated;
use App\Http\Requests\BookRequest;
use App\Http\Services\BookService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class bookController extends Controller
{

    
    public function __construct(public  BookService $bookService){}

    public function store(BookRequest $request){
        $this->bookService->store($request->only("name","overview","category_id","book_gallery","book_cover","book_file"));
        return response()->json(['message'=>'Your book has been submitted to the admin successfully. Wait for it to be activated '],201);
    }

    public function index()
    {
      $data= Cache::rememberForever('books',function(){

            return BookResource::collection(Book::Active()->latest()->paginate(10));
        });
        return $data;
    }
    public function show(BookRequest $request)
    {
        return new  BookResource(Book::Active()->find($request->book_id));
    }
    public function bookByCategoryId(BookRequest $request)
    {
       
        return BookResource::collection(Book::Active()->where('category_id',$request->category_id)->paginate(10));
    }
    public function bestRating()
    {
        return BookResource::collection(Book::Active()->with(['coverImage', 'Images'])->orderBy('rating', 'desc')->paginate(4));
    }


    public function foryou(){
       if(auth()->check()){
     
        $categoryForYou=DB::table('likes')
        
        ->where('likes.user_id',auth('user')->id())
        
        ->join('books', 'books.id','=','likes.book_id')
        
        ->selectRaw('books.category_id, COUNT(likes.id) AS num_likes')
        
        ->groupBy('books.category_id')
        
        ->orderBy('num_likes','DESC')
        
        ->pluck('category_id')
        
        ->take(5);
        
      if(count($categoryForYou))
     
          return Book::whereIn('category_id',$categoryForYou)->paginate(10);
       }
     
      $randomCategories=Category::inRandomOrder()->take(5)->get('id')->pluck('id');
      return Book::whereIn('category_id',$randomCategories)->paginate(10);
      

    }

    public function evaluate(BookRequest $request){
      
       auth()->user()->evaluations()->syncWithoutDetaching([$request->book_id=>['value'=>$request->value]]);
       
       Evaluated::dispatch($request->book_id);
    
       return response()->json(['message'=>'Evaluation successfully'],201);
    
    }

}