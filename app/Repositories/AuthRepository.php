<?php

namespace App\Repositories;

use App\Models\Auth as AuthTable;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function create($user_id, $password)
    {
        AuthTable::create([
            'user_id' => $user_id,
            'type' => 'native',
            'social_id' => null,
            'password' => Hash::make($password),
        ]);
    }
}
