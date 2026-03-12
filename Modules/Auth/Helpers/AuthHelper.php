<?php

namespace Modules\Auth\Helpers;

use Modules\User\Entities\User;

class AuthHelper
{
    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function createToken($user, $deviceIdentity)
    {
        return $user->createToken($deviceIdentity)->plainTextToken;
    }

    public function revokeToken($user)
    {
        return $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    }
}
