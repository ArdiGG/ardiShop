<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckCreditsController extends Controller
{
    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (isset($user)) {
            $auth = Auth::where('user_id', $user->id)->where('type', 'native')->first();

            if(isset($auth) && Hash::check($request->password, $auth->password)) {
                \Illuminate\Support\Facades\Auth::login($user);
                return redirect('/');
            }
        }

        return redirect()->back();
    }
}
