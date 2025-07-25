<?php

namespace App\Forms;

use App\Exception\ValidationException;
use Core\Forms\Form;
use Core\Validator;

class LogInForm extends Form
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {

        if (!Validator::email($this->email)) {
            $this->errors['email'] = "Email is not valid.";
        }

        if (!Validator::required($this->email)) {
            $this->errors['email'] = "Email is required.";
        }

        if (!Validator::required($this->password)) {
            $this->errors['password'] = "Password is required.";
        }

    }

    public static function validate($attributes): array
    {

        $instance = new static(
            $attributes['email'] ?? "",
            $attributes['password'] ?? "",
        );

        $userRepository = \Core\Application::container()->resolve(\App\Repositories\UserRepositoryInterface::class);

        $user = $userRepository->findByEmail($instance->email);
        if (!$user) {
            $instance->errors['email'] = "User with this email does not exist.";
        } else {
            if (!password_verify($instance->password, $user->password)) {
                $instance->errors['password'] = "Password is incorrect.";
            }
        }

        if ($instance->failed()) {
            throw new ValidationException($instance->errors);
        }

        return $instance->toArray();
    }

}