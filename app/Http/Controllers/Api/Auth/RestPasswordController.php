<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use app\Http\Services\UserService;
use App\Jobs\sendResetPasswordCode;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class RestPasswordController extends Controller
{
    public function index(UserRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user) {

            Bus::batch(new sendResetPasswordCode($request->email))
                ->then(function (Batch $batch) {

                })->dispatch();
        }

        return response()->json(['message' => 'If this email is already registered, a code will be sent to your email to reset your password']);

    }

    public function update(UserRequest $request, UserService $userService)
    {

        $user = User::firstWhere('rest_token', $request->token)->first();

        $userService->changePassword($user, $request->passowrd);

        return response()->json(['message' => 'Password updated successful']);

    }
}
