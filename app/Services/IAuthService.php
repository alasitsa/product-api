<?php

namespace App\Services;

interface IAuthService
{
    public function login(string $email, string $password): string;
    public function logout(int $userId): void;
}
