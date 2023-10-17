<?php

namespace app\Http\Services;

class UserService
{
    public function changePassword($user, $new_password)
    {
        $user->update([
            'password' => $new_password,
            'rest_token' => null,
            'reset_token_expiration' => null,
        ]);

        return $user;
    }
}
