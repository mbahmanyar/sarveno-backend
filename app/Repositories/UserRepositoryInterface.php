<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function find(int|string $id): User|null;

    public function findOrFail(int|string $id): User;

    public function save(User $user): User;

    public function create(User $user): User;

    public function update(User $user): User;

    public function findByEmail(string $email);

}