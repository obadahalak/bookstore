<?php

namespace App\Http\Services;

use App\Models\Link;

class DownloadLinkBookService
{
    public function store($token, $book)
    {
        return Link::create([
            'token' => $token,
            'book_id' => $book,
            'url' => $token,
        ]);
    }

    public function inactivationLink($token)
    {
        Link::where('token', $token)->update([
            'active' => false,
        ]);

        return true;
    }
}
