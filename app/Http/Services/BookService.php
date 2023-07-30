<?php

namespace App\Http\Services;

use App\Models\Book;
use App\Models\Link;
use App\Events\PublishedBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class BookService {

    
   
  
    public function createBook($data){
    
         DB::transaction(function() use ($data){
         
            $book=Book::create([
                'name'=>$data->name,
                'overview'=>$data->overview,
                'category_id'=>$data->category_id,
                'page_count'=>$data->page_count,
                'user_id'=>auth()->id()                
            ]);
        
            $this->book_gallery($book , $data['book_gallery']);

        
            $this->coverImage($book , $data['book_cover']);
           

            $this->bookFile($book , $data['book_file']);
          
        
    });
    }

    protected function book_gallery($book,$data){
        foreach($data as $book_images){
               
            $book->Images()->create([
                'file'=>Storage::disk('public')->url($book_images['src']->store('bookGaller','public')),
                'filename'=>$book_images['src']->getClientOriginalName(),
                'type'=>'gallary'
            ]); 
        }
        return $book;
    }
    protected function coverImage($book, $data){
        $book->coverImage()->create([
            'file'=>Storage::disk('public')->url($data->store('bookCover','public')),
            'filename'=>$data->getClientOriginalName(),
            'type'=>'cover'
           
            
        ]);
        return $book;
    }
    protected function bookFile($book ,$data){
        $book->bookFile()->create([
            'file'=>Storage::disk('public')->url($data->store('books','public')),
            'filename'=>$data->getClientOriginalName(),
            'type'=>'file'
        ]);
        return $book;
  
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

        public static function isAvilableBook($token){
            $book=Link::whereToken($token)->whereActive(true)->first();
            if($book)return $book->book_id;
            abort(403,'link has been expired');
        }

        public static function inactivationLink($token){
            Link::where('token',request()->token)->update([
                'active'=>false,
            ]);
            return true;
        }
    
}
