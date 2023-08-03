<?php

namespace App\Services;

use App\Models\User;

interface IUserService
{
    /**
     * @param int $id
     * @return User
     */
    public function getUser(int $id): User;

    /**
     * @param int $id
     * @param array $params
     * @return void
     */
    public function updateUser(int $id, array $params): void;
}
