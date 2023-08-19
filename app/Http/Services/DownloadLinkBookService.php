<?php

namespace App\Http\Services;

use App\Models\Book;
use App\Models\Link;
use App\Events\PublishedBook;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Storage;


class  DownloadLinkBookService
{

    public function store($token, $book)
    {
        return  Link::create([
            'token' => $token,
            'book_id' => $book,
            'url' => $token
        ]);
    }


    public  function inactivationLink($token)
    {
        Link::where('token', request()->token)->update([
            'active' => false,
        ]);
        return true;
    }
}
