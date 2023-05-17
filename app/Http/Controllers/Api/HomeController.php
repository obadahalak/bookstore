<?php


namespace App\Http\Controllers\Api;


use App\Models\book;
use App\Models\User;
use App\Models\Auther;
use App\Http\Resources\BookResource;
use App\Http\Resources\HomeResource;
use  App\Http\Controllers\Controller;
use App\Http\Resources\AutherResource;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function index()
    {
        // return  AutherResource::collection(User::Author()->with(['image'])->inRandomOrder()->take(5)->get());
      $homepage= Cache::remember('homepage',60,function(){
        return $homepage=[
            'NEW BOOKS'=>
            BookResource::collection(book::with(['Images','coverImage'])->latest()->take(5)->get()),
            'TOP RATING'=>
            BookResource::collection(book::with(['Images','coverImage'])->orderby('rating')->take(5)->get()),
      
          ];

        });
        return response()->json($homepage);
    }
   

}
