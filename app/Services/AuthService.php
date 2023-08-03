<?php

namespace App\Services;

use App\Exceptions\IncorrectDataException;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repositories\IUserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuthService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(string $email, string $password): string
    {
        $user = $this->userRepository->getUserByEmail($email);
        if ($user && Hash::check($password, $user->password)) {
            return $user->createToken('user_token')->plainTextToken;
        }
        throw new UserNotFoundException();
    }

    public function logout(int $userId): void
    {
        $user = $this->userRepository->getUser($userId);
        if (!$user) {
            throw new IncorrectDataException();
        }
        $user->tokens()->delete();
    }
}
