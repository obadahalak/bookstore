<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function createToken($user)
    {
        $token = $user->createToken($user);
        return $token;
        return response()->json(['token' => $token->plainTextToken]);
    }
    public function createUser(UserRequest $Request)
    {
        $createUser = User::create($Request->validated());
        return $this->createToken($createUser);
    }
    public function authUser(UserRequest $Request)
    {
          $authUser = Auth::attempt(['email'=>$Request->email,'password'=>$Request->password]);

        return $this->createToken($authUser);
    }
}
