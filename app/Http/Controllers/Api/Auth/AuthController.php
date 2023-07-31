<?php

namespace App\Http\Controllers\Api\Auth;


use App\Models\User;
use Illuminate\Bus\Batch;
use App\traits\UploadImage;
use App\Http\Requests\UserRequest;
use App\Jobs\sendResetPasswordCode;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use app\Http\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    use UploadImage;

    public function store(UserRequest $request){
      
        $account=User::create($request->validatedData());
        $token= $account->createToken('user-Token')->accessToken;
        $account->assignRole('user');
        return response()->data(['token'=>$token,'ability'=>'user']);
 
    }
 
    public function login(UserRequest $Request)
    {
       
        $user = User::where('email', $Request->email)->first();
        if (!$user || ! Hash::check($Request->password, $user->password)) {
            return throw ValidationException::withMessages([
                'email' => ['Email or password not correct'],
           
            ]);
        }
        $token= $user->createToken('user-Token')->accessToken;
        return response()->data(['token'=>$token,'ability'=>$user->getRoleNames()]);
        
    }
  
   
 

   
    
}
    