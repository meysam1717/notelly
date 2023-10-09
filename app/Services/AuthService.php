<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    public function loginUser(User $user): void
    {
        Auth::login($user);
    }
}
