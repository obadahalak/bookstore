<?php


namespace App\Http\Controllers\Api;


use App\Models\book;
use App\Models\Auther;
use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;
use App\Http\Resources\AutherResource;

class HomeController extends Controller
{


    public function newBooks(){
        return BookResource::collection(Book::with(['coverImage','Images'])->latest()->paginate(4));
    }
    public function bestRating(){
        return BookResource::collection(Book::with(['coverImage','Images'])->orderBy('rating','desc')->paginate(4));
    }

    public function authors(){
        return AutherResource::collection(Auther::with(['image'])->paginate(4));
    }



}
