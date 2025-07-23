<?php

namespace App\Models;

use Core\Model;

class User extends Model
{

    public string $password {
        set(string $value) {
            $this->password = password_hash($value, PASSWORD_BCRYPT);
        }
    }

    public function __construct(
        public ?int   $id,
        public string $email,
        string        $password,
    )
    {
        $this->password = $password;
    }

    public static function initiate(array $properties): static
    {
        $object = new static(
            $properties['id'] ?? null,
            $properties['email'] ?? '',
            $properties['password'] ?? ''
        );


        return $object;
    }
}