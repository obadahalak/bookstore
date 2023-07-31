<?php


namespace App\Http\Controllers\Api;


use App\Models\book;

use App\Http\Resources\BookResource;
use  App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function index()
    {
     
      $homepage= Cache::remember('homepage',60,function(){
        return $homepage=[
            'NEW BOOKS'=>
            BookResource::collection(book::with(['images','coverImage'])->latest()->take(3)->get()),
            'TOP RATING'=>
            BookResource::collection(book::with(['images','coverImage'])->orderby('rating')->take(3)->get()),
      
          ];

        });
        return response()->json($homepage);
    }
   

}
