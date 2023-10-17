<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function login(AdminRequest $request)
    {
        $admin = Admin::firstWhere('email', $request->email);

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return throw ValidationException::withMessages([
                'email' => ['Email or password not correct'],

            ]);
        }

        return response()->json(['token' => $admin->createToken('adminToken', ['*'])->accessToken, 'ability' => 'admin']);

    }
}
