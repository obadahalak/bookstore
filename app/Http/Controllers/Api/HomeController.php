<?php


namespace App\Http\Controllers\Api;


use App\Models\book;
use App\Models\Auther;
use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;
use App\Http\Resources\AutherResource;
use App\Http\Resources\HomeResource;

class HomeController extends Controller
{


    public function homePage(){
        return HomeResource::collection(book::with('coverImage')->paginate(4));

    }
    public function bestRating(){
        return BookResource::collection(Book::with(['coverImage','Images'])->orderBy('rating','desc')->paginate(4));
    }

    public function authors(){
        return AutherResource::collection(Auther::with(['image'])->paginate(4));
    }



}
