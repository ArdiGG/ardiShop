<?php

namespace App\Repositories;

use App\Models\Auth as AuthTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function create($user, $password)
    {
        $auth = AuthTable::where('type', 'native')->where('user_id', $user->id)->first();

        if(! is_null($auth)) {
            return redirect()->route('register.index');
        }

        AuthTable::create(
            [
                'user_id' => $user->id,
                'type' => 'native',
                'social_id' => null,
                'password' => Hash::make($password),
            ]);

        Auth::login($user);

        return redirect('/');
    }
}
