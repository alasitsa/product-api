<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements IUserRepository
{
    /**
     * @param int $id
     * @return User|null
     */
    public function getUser(int $id): User|null
    {
        return User::find($id);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null
    {
        return User::where('email', '=', $email)->first();
    }

    /**
     * @param int $userId
     * @param array $params
     * @return void
     */
    public function updateUser(int $userId, array $params): void
    {
        $user = $this->getUser($userId);
        foreach ($params as $field => $value) {
            $user[$field] = $value;
        }
        $user->save();
    }
}
