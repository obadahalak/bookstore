<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\traits\UploadImage;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use UploadImage;

    public function store(UserRequest $request)
    {

        $account = User::create($request->validatedData());
        $token = $account->createToken('user-Token')->accessToken;
        $account->assignRole('user');

        return response()->data(['token' => $token, 'ability' => 'user']);
    }

    public function login(UserRequest $Request)
    {

        $user = User::where('email', $Request->email)->first();
        if (! $user || ! Hash::check($Request->password, $user->password)) {
            return response()->data(
                key: 'error',
                data: ['email' => ['Email or password not correct']],
                code: 422
            );
        }
        $token = $user->createToken('user-Token')->accessToken;

        return response()->data(data: ['token' => $token, 'ability' => $user->getRoleNames()]);
    }
}
