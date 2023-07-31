<?php
namespace App\Http\Controllers\Api;


use App\Models\Book;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Services\BookService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DownloadBookController extends Controller
{
    public function store(Book $book){
        
        $token=generate_token();
        
       $data= Link::create([
            'token'=>$token,
            'book_id'=>$book->id,
            'url'=>$token
        ]);
        return response()->data($data->url);
    }

    
    public function index(){
           $book=BookService::isAvilableBook(request()->token); 
        if($book){
            BookService::inactivationLink(request()->token);
         return  Storage::disk('public')->download("/books/$book.pdf");
        }
 
    }
}
