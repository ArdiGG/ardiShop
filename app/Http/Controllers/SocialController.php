<?php

namespace App\Http\Controllers;

use App\Actions\SocialLoginAction;
use App\Actions\UserCreateAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Auth as AuthTable;

class SocialController extends Controller
{
    private SocialLoginAction $socialLogin;

    public function __construct(SocialLoginAction $socialLogin)
    {
        $this->socialLogin = $socialLogin;
    }

    public function login($type)
    {
        $googleUser = Socialite::driver($type)->user();

        $user = $this->socialLogin->run($googleUser, $type);

        Auth::login($user);

        return redirect('/');
    }

    public function redirect($type)
    {
        return Socialite::driver($type)->redirect();
    }
}
