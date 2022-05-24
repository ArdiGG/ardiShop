<?php

namespace App\Actions;

use App\Models\Auth;
use App\Models\User;

class SocialLoginAction
{
    public function run($userData, $type)
    {
        $user = User::firstOrCreate(
            [
                'email' => $userData->email
            ],

            [
                'email' => $userData->email,
                'name' => $userData->name
            ]

        );

        Auth::firstOrCreate([
            'user_id' => $user->id,
            'type' => $type,
            'social_id' => $userData->id
        ], [
            'user_id' => $user->id,
            'type' => $type,
            'social_id' => $userData->id
        ]);

        return $user;
    }
}
