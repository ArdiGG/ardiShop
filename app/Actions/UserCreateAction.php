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

    public function run($googleUser)
    {
        $user = $this->userRepository->create($googleUser);
        $this->authRepository->create($googleUser->id, $user->id);

        return $user;
    }
}
