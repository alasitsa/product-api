<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\IUserRepository;

class UserService implements IUserService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUser(int $id): User
    {
        return $this->userRepository->getUser($id);
    }

    /**
     * @param int $id
     * @param array $params
     * @return void
     */
    public function updateUser(int $id, array $params): void
    {
        $this->userRepository->updateUser($id, $params);
    }
}
