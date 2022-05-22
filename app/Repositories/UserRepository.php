<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $userData): User
    {
        $user = User::firstOrCreate([
            'email' => $userData['email']
        ],
        ['name' => $userData['name']]);

        return $user;
    }
}
