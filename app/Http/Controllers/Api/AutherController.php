<?php

namespace App\Http\Controllers\Api;


use App\Models\Auther;
use App\Http\Requests\AutherRequest;
use  App\Http\Controllers\Controller;
use App\Http\Resources\AutherResource;
use App\Models\User;

class AutherController extends Controller
{
    
    public function test(User $user){
        
        return $user;
    }
    public function authors(){
        return AutherResource::collection(User::Author()->with(['image'])->paginate(10));
    }

    public function author(AutherRequest $request){
        return new  AutherResource(User::with(['image'])->find($request->id));
    }
   

}
