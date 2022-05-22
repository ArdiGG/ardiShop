<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create($googleUser): User
    {
        $user = User::where('email', $googleUser->email)->firstOrCreate([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
        ]);

        return $user;
    }
}
