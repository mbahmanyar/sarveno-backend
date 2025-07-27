<?php

namespace App\Repositories;

use App\Models\User;
use Core\Database;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(
        protected Database $database
    )
    {
    }

    public function find(int|string $id): User|null
    {
        $result = $this->database->query("SELECT * FROM users WHERE id=:id", ['id' => $id])->fetch();
        return $result ? User::initiate($result) : null;
    }

    public function findOrFail(int|string $id): User
    {
        $item = $this->find($id);
        if (!$item) {
            throw new \App\Exception\NotFoundException("Item not found", 404);
        }
        return $item;
    }

    public function save(User $user): User
    {
        if ($user->id) {
            return $this->update($user);
        }

        return $this->create($user);
    }

    public function create(User $user): User
    {

        $this->database->query("INSERT INTO users (email, password) VALUES (:email, :password)", [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $user->id = $this->database->lastInsertId();

        return $user;
    }

    public function update(User $user): User
    {

        $this->database->query("UPDATE users SET email=:email, password=:password WHERE id=:id", [
            'email' => $user->email,
            'password' => $user->password,
            'id' => $user->id
        ]);

        return $user;
    }

    public function findByEmail(string $email): User|null
    {
        $result = $this->database->query("SELECT * FROM users WHERE email=:email", ["email" => $email])->fetch();

        return $result ? User::initiate($result) : null;
    }
}