<?php

namespace App\Http\Controllers\Api;


use App\Models\Auther;
use  App\Http\Controllers\Controller;
use App\Http\Resources\AutherResource;

class AutherController extends Controller
{
    public function authors(){
        return AutherResource::collection(Auther::with(['image'])->paginate(10));
    }

    public function author($id){
        return AutherResource::collection(Auther::with(['image'])->findOrFail($id));
    }

}
