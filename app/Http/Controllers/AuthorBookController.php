<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\AuthorResource;

class AuthorBookController extends Controller
{
    public function index(){  
       
        $author=User::Author()->with(['image','books'])->find(request()->id);
       
        return response()->data(AuthorResource::make($author));
    }

}
