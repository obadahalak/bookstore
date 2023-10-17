<?php

namespace App\Http\Controllers\Api;

use App\Events\TrackingUserActivity;
use App\Http\Controllers\Controller;
use App\Http\Services\BookService;
use App\Http\Services\DownloadLinkBookService;
use App\Models\Book;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadBookController extends Controller
{
    public function store(Book $book, DownloadLinkBookService $service)
    {

        $token = generate_token();
        $link = $service->store($token, $book->id);

        return response()->data($link->url);
    }

    public function index()
    {
        $bookLink = Link::whereToken(request()->token)->first();

        event(new TrackingUserActivity($bookLink->book_id));
        if (Storage::disk('public')->exists("/books/{$bookLink->book_id}.pdf")) {
            return Storage::disk('public')->download("/books/{$bookLink->book_id}.pdf");
        }

        // BookService::inactivationLink(request()->token);
        // }
    }
}
