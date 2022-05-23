<?php

namespace App\Services\Auth;

use App\Models\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CheckCreditsService
{
    public function attempt(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (isset($user)) {
            $auth = Auth::where('user_id', $user->id)->where('type', 'native')->first();

            if(isset($auth) && Hash::check($credentials['password'], $auth->password)) {
                \Illuminate\Support\Facades\Auth::login($user);
                return true;
            }
        }

        return false;
    }
}
