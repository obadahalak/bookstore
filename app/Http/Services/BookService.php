<?php

namespace App\Http\Services;

use App\Models\Book;
use setasign\Fpdi\Fpdi;
use App\Events\PublishedBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;


class BookService {

    
    public function store($data){
       
       
         DB::transaction(function() use ($data){

          $book=auth()->user()->books()->create(collect($data)->only("name","overview","category_id")->toArray());
        
            foreach($data['book_gallery'] as $book_images){
               
                $book->Images()->create([
                    'file'=>Storage::disk('public')->url($book_images['src']->store('bookGaller','public')),
                    'filename'=>$book_images['src']->getClientOriginalName(),
                    'type'=>'gallary'
                ]); 
            }
           
            $book->coverImage()->create([
                'file'=>Storage::disk('public')->url($data['book_cover']->store('bookCover','public')),
                'filename'=>$data['book_cover']->getClientOriginalName(),
                'type'=>'cover'
               
                
            ]);
            
           $book->bookFile()->create([
                'file'=>Storage::disk('public')->url($data['book_file']->store('books','public')),
                'filename'=>$data['book_file']->getClientOriginalName(),
                'type'=>'file'
            ]);
      
        
    });
    }

    public function active(Book $book, $status){
        
        $book->update(['active'=>$status]);
        event(new PublishedBook($book));
      
    }
    
    public static  function getUserWishlist(){
       
       return  DB::table('likes')
                    ->where('likes.user_id',auth()->user()->id)
                    ->join('books as b','b.id','=','likes.book_id')
                    ->select('b.id')
                    ->pluck('b.id');
        }
    
}
