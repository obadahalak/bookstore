<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\User;

class AuthorBookController extends Controller
{
    public function index()
    {

        $author = User::Author()->with(['image', 'books'])->find(request()->id);

        return response()->data(AuthorResource::make($author));
    }
}
