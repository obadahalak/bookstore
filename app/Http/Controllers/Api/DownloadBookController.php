<?php

namespace App\Http\Controllers\Api;


use App\Models\Book;
use App\Models\Link;
use App\Events\TrackingUserActivity;
use Illuminate\Http\Request;
use App\Http\Services\BookService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DownloadBookController extends Controller
{
    public function store(Book $book)
    {

        $token = generate_token();

        $link = Link::create([
            'token' => $token,
            'book_id' => $book->id,
            'url' => $token
        ]);
        return response()->data($link->url);
    }


    public function index()
    {
        $bookLink = Link::whereToken(request()->token)->first();
       
        event(new TrackingUserActivity($bookLink->book_id));
        if (Storage::disk('public')->exists("/books/$bookLink->book_id.pdf")) 
            return  Storage::disk('public')->download("/books/$bookLink->book_id.pdf");
        
        // BookService::inactivationLink(request()->token); 
        // }
    }
}
