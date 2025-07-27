<?php

namespace App\Forms;

use App\Exception\ValidationException;
use App\Repositories\UserRepositoryInterface;
use Core\Forms\Form;
use Core\Validator;

class CreateSignUpForm extends Form
{

    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }

    public static function validate($attributes): array
    {

        $instance = new static(
            $attributes['email'] ?? "",
            $attributes['password'] ?? "",
        );


        if (!Validator::email($instance->email)) {
            $instance->errors['email'] = "Email is not valid.";
        }

        $repository = app()->resolve(UserRepositoryInterface::class);

        if ($repository->findByEmail($instance->email)) {
            $instance->errors['email'] = "Email already exists.";
        }

        if (!Validator::required($instance->email)) {
            $instance->errors['email'] = "Email is required.";
        }

        if (!Validator::required($instance->password)) {
            $instance->errors['password'] = "Password is required.";
        }

        if (! preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $instance->password)) {
            $instance->errors['password'] = "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one number.";
        }

        if ($instance->failed()) {
            throw new ValidationException($instance->errors);
        }

        return $instance->toArray();
    }

}