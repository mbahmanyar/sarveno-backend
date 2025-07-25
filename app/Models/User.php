<?php

namespace App\Models;

use Core\Interfaces\AuthenticationInterface;
use Core\Model;

class User extends Model implements AuthenticationInterface
{

    public function __construct(
        public ?int   $id,
        public string $email,
        public string $password,
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

    public function hashPassword() : void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
}