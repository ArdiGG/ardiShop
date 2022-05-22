<?php

namespace App\Http\Controllers;

use App\Actions\UserCreateAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Auth as AuthTable;

class SocialController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginWithGoogle(UserCreateAction $userCreate)
    {
        $googleUser = Socialite::driver('google')->user();

        $user = $userCreate->run($googleUser);

        Auth::login($user);

        return redirect('/');
    }

    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $user = User::where('facebook_id', $facebookUser->id)->first();

        if (is_null($user)) {
            $user = User::create([
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'facebook_id' => $facebookUser->id,
                'password' => encrypt('facebookUser'),
            ]);
        }

        Auth::login($user);

        return redirect('/');
    }
}
