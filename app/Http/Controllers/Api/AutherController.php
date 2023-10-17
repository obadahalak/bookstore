<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\User;

class AuthorController extends Controller
{
    public function types()
    {
        return response()->data(User::Author()->distinct()->pluck('type'));
    }

    public function index()
    {
        $authors = User::Author()->with(['image']);
        $authors->when(request('search'), function ($q) use ($authors) {
            return $authors->where('name', 'LIKE', '%' . request()->search . '%')->paginate(10);
        });

        return response()->paginate(AuthorResource::collection($authors->paginate(10)));
    }

    public function show(User $user)
    {
        $author = User::Author()->with(['image', 'books'])->find($user->id);

        return response()->data(key: 'data', data: AuthorResource::make($author));
    }

    public function books()
    {

        $author = User::Author()->with(['image', 'books'])->find(request()->id);

        return response()->data(AuthorResource::make($author));
    }
}
