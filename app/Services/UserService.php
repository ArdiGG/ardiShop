<?php

namespace App\Services;

use App\Models\Auth;
use App\Models\User;

class UserService
{
    public function login($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (is_null($user)) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            Auth::create([
                'user_id' => $user->id,
                'type' => 'native',
                'social_id' => null,
                'password' => bcrypt($data['password'])
            ]);

        } else {
            $auth = Auth::where('user_id', $user->id, )->where('type', 'native')->first();

            if(is_null($auth)) {
                Auth::create([
                    'user_id' => $user->id,
                    'type' => 'native',
                    'social_id' => null,
                    'password' => bcrypt($data['password'])
                ]);

            } else {
                return null;
            }

        }

        return $user;
    }
}
