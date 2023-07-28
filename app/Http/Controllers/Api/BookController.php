<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Category;
use App\Events\Evaluated;
use App\Models\Link;
use App\Http\Requests\BookRequest;
use App\Http\Services\BookService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class bookController extends Controller
{

    
    public function __construct(public  BookService $bookService){}

    public function store(BookRequest $request){
        return $request->validated_data();
        $this->bookService->store($request->only("name","overview","category_id","book_gallery","book_cover","book_file"));
        return response()->data('Your book has been submitted to the admin successfully. Wait for it to be activated ',201);
    }

    
    
    public function index()
    {
        $category=Category::query();
        $category->with(['books'=> function($q){
            $q->limit(3);
        }]);
        
        if(isset(request()->search)){
             
             $category->whereHas('books',function($query){
                $query->where('name','LIKE','%'.request()->search.'%');
            });
        }    
        
        return response()->paginate($category->paginate(5));
    
        
    }
    public function getBooks(){
        
        $category=Category::whereId(request()->category_id)->first();
        $Book=Book::where('category_id',request()->category_id)
        ->skip(request()->skip)->take(3)
        ->where('name','LIKE','%'.request()->name.'%')
        ->get();
        if(  (request()->skip *=2) >=$category->books()->count()  )
            
               
            return response()->json([
                'data'=>BookResource::collection($Book),
                'status'=>false,
            ]); 
        
    

            return response()->json([
                'data'=>BookResource::collection($Book),
                'status'=>true,
            ]);
    
    }
    public function show(Book $book)
    {
        return new  BookResource(Book::Active()->with(['Images'])->find($book->id));
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
        return $books;
      

}

    public function evaluate(BookRequest $request){
      
       auth()->user()->evaluations()->syncWithoutDetaching([$request->book_id=>['value'=>$request->value]]);
       
       Evaluated::dispatch($request->book_id);
    
       return response()->json(['message'=>'Evaluation successfully'],201);
    
    }

    public function createUrl(Book $book){
        
        $token=generate_token();
        
       $data= Link::create([
            'token'=>$token,
            'book_id'=>$book->id,
            'url'=>$token
        ]);
        return response()->data($data->url);
    }

    
    public function download(){
           $book=BookService::isAvilableBook(request()->token); 
        if($book){
            BookService::inactivationLink(request()->token);
         return  Storage::disk('public')->download("/books/$book.pdf");
        }
 
    }

}