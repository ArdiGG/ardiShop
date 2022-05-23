<?php

namespace App\Actions;

use App\Repositories\AuthRepository;
use App\Repositories\UserRepository;

class UserCreateAction
{
    private UserRepository $userRepository;
    private AuthRepository $authRepository;

    public function __construct(UserRepository $userRepository, AuthRepository $authRepository)
    {
        $this->userRepository = $userRepository;
        $this->authRepository = $authRepository;
    }

    public function run($userData)
    {
        $password = $userData['password'];

        $user = $this->userRepository->create($userData);
        $this->authRepository->create($user, $password);
    }
}
