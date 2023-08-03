<?php

namespace App\Repositories;

use App\Models\User;

interface IUserRepository
{
    /**
     * @param int $id
     * @return User|null
     */
    public function getUser(int $id): User|null;

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null;

    /**
     * @param int $userId
     * @param array $params
     * @return void
     */
    public function updateUser(int $userId, array $params): void;
}
