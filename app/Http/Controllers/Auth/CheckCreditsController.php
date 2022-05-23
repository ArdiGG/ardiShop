<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Auth;
use App\Models\User;
use App\Services\Auth\CheckCreditsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckCreditsController extends Controller
{
    private CheckCreditsService $service;

    public function __construct(CheckCreditsService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if ($this->service->attempt($data)) {
            return redirect('/');
        }

        return redirect()->back();
    }
}
