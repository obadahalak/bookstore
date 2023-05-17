<?php

namespace App\Http\Controllers;


use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{

    
    public function store(BookRequest $request ){
        $likeOrUnlike=$request->status ? 'syncWithoutDetaching' : 'detach';
         auth()->user()->likes()->$likeOrUnlike([$request->book_id]);
         return response()->json(['message'=>'Successfully']);
    }

    public function Wishlist(){
        $wishlist=DB::table('likes')
                  ->where('likes.user_id',auth()->user()->id)
                  ->join('books as b','b.id','=','likes.book_id')
                  ->join('categories as c','c.id','=','b.category_id')
                  ->join('users as u','u.id','=','b.user_id');


                 $data=   $wishlist->join('images', function($q) {
                    $q->on('images.imageable_id', '=', 'b.id');
                    $q->where('images.imageable_type', '=', 'App\Models\Book');
                    $q->where('images.type','cover');
                })
           
                   ->select(
                    'b.id as id','b.name as name'
                    ,'b.overview as overview'
                    ,'b.rating as rating'
                    ,'u.name as auther'
                    ,'c.title as category'
                    ,'images.file'
                   
                    )->paginate(10);
        
       return $data;
    }

}
