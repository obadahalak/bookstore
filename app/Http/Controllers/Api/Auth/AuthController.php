<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    protected function validationException()
    {
        throw ValidationException::withMessages([
            'email' => ['Email or password not correct'],
        ]);
    }
    public function createToken($user)
    {

        $token = $user->createToken('test');

        return response()->json(['token' => $token->plainTextToken]);
    }
    public function createUser(UserRequest $Request)
    {
        $createUser = User::create($Request->validated());
        return $this->createToken($createUser);
    }

    public function authUser(UserRequest $Request)
    {
        $user = User::where('email', $Request->email)->first();
        if (!$user || !Hash::check($Request->password, $user->password)) {
            return $this->validationException();
        }else{
                return $this->createToken($user);
        }
    }

    public function getUser(){
        return  new UserResource(auth()->user());
    }

    public function users(){
        return User::all();
    }

}
