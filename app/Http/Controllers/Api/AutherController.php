<?php

namespace App\Http\Controllers\Api;


use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use  App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class AuthorController extends Controller
{
    
    // public function test(User $user){
        
    //     return $user;
    // }
    public function types(){
        return User::Author()->distinct()->pluck('type');
    }
    public function authors(){
        $authors=User::Author()->with(['image']);
          $authors->when(request('search'),function($q) use($authors){
             return $authors->where('name','LIKE','%'.request()->search.'%')->paginate(10);
        });

        return response()->paginate(AuthorResource::collection($authors->paginate(10)));
    }

    public function author(){
        $author=User::Author()->with(['image'])->find(request()->id);
        if($author)
            return AuthorResource::make($author);
            return response()->json (['error'=>'author not found'],404);   
    }

    public function books(){  
       
        $author=User::Author()->with(['image','books'])->find(request()->id);
       
        return AuthorResource::make($author);
    }

    
}
