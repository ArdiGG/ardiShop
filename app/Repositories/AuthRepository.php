<?php

namespace App\Repositories;

use App\Models\Auth as AuthTable;

class AuthRepository
{
    public function create($googleUser_id, $user_id)
    {
        AuthTable::where('type', 'google')->where('social_id', $googleUser_id)->firstOrCreate([
            'user_id' => $user_id,
            'type' => 'google',
            'social_id' => $googleUser_id,
            'password' => null,
        ]);
    }
}
