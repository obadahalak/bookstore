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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    use UploadImage;

    public function store(UserRequest $request){
      
        $account=User::create($request->ValidatedData());
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
        return response()->data(['token'=>$token]);
        
    }
  
   
  public function resetPassword(UserRequest $request){

     $user=User::where('email',$request->email)->first();

    if($user){

        $batch = Bus::batch(
            
            new sendResetPasswordCode($request->email)
            
            )->then(function (Batch $batch) {
                // Log::info('bb');
            })->dispatch();
        }
     
    return response()->json(['message'=>'If this email is already registered, a code will be sent to your email to reset your password']);

   
  } 

    public function codeCheck(UserRequest $request){
    
    $user=User::firstWhere('rest_token', $request->token)->first();
    
    $user->update([
        'password'=>$request->password,
        'rest_token'=> null,
        'reset_token_expiration' => null,
    ]); 
        return response()->json(['message' => 'Password updated successful']);

        
    }

    public function profile(){
        return Cache::rememberForever(auth()->user()->email,function(){
            
            return new UserResource(auth()->user());
        });

}

    public function updateUserImage($requestImage,$user){
        
        $updateOrCreate=$user->image ? 'update': 'create';
        $updateOrCreate == 'update'? $this->unlinkImage($user->image->filename,'UserProfileImages')  :true;
        $uploadImage=$this->uploadSingleImage($requestImage,'UserProfileImages');
             
        $user->image()->$updateOrCreate([
                'file' =>$uploadImage['url'],
                'filename'=>$uploadImage['filename'],
            ]);
          return response()->json(['message'=>''.$updateOrCreate.' profile updated successfully']);  
    }

    public function update(UserRequest $request)
    {
       
            $return = [];
            $user = auth('user')->user();
            $updateInformation=[
                'name' => $request->name,
                'email' => $request->email,
                'bio' => $request->bio,
                'type' => $request->Author_type,
            ];
            
            if($request->filled('new_password'))
                $updateInformation=  array_merge($updateInformation,['password'=> $request->new_password ]);
            
            $user->update($updateInformation);
            $return=['message'=>'information updated sucessfully.'];    
       
        if(isset($request->image)) 
         return $this->updateUserImage($request->image, $user) ;
        return  response()->json($return);
        
        
         
    }
    
}
    