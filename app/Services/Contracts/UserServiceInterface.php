<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function register(array $data): User;
    public function login(array $credentials): array;
    public function logout(User $user): void;
}
