<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function createUser(UserRequest $Request){

        $createUser=User::create([$Request->validated()]);
         return $createUser;
     }
}
