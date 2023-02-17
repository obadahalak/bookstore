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

use function PHPUnit\Framework\isEmpty;

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
        } else {
            return $this->createToken($user);
        }
    }

    public function getUser()
    {
        return  new UserResource(auth()->user());
    }
    public function cheackOldPassword($old_password, $userPassword)
    {
        if (Hash::check($old_password, $userPassword)) return  true;
        return false;
    }
    public function update(UserRequest $request)
    {
        $return = [];
        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'email' => $request->email,
            'address' => $request->address,
        ]);
        $return['profile'] = 'user profile updated successfully';
        if ($request->old_password) {
            if ($this->cheackOldPassword($request->old_password, auth()->user()->password)) {

                $user->update([
                    'password' => $request->new_password,
                ]);

                $return['password'] = 'user password changed successfully';
            }
        }
        if($request->image){
                $path=$request->image->store('public','userImages');
                $user->image()->create([
                    'file'=>'public/'.$path
                ]);
                $return['image'] = 'image profile updated successfully';
        }
        return response()->json($return);
    }


    public function users()
    {
        return User::all();
    }
}
