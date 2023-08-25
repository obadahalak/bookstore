<?php

namespace App\Http\Controllers\Api;


use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use  App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\User;

class AuthorController extends Controller
{
    
    public function types(){
        return response()->data(User::Author()->distinct()->pluck('type')); 
    }
    public function index(){
        $authors=User::Author()->with(['image']);
          $authors->when(request('search'),function($q) use($authors){
             return $authors->where('name','LIKE','%'.request()->search.'%')->paginate(10);
        });

        return response()->paginate(AuthorResource::collection($authors->paginate(10)));
    }

    public function show(){
        $author=User::Author()->with(['image'])->find(request()->id);
        if($author)
            return AuthorResource::make($author);
            return response()->data(key:"error",data:['error'=>'author not found'],code: 422);
    }

    public function books(){  
       
        $author=User::Author()->with(['image','books'])->find(request()->id);
       
        return response()->data(AuthorResource::make($author));
    }

    
}
