<?php

namespace App\Controllers\Api;

use App\Forms\CreateSignUpForm;
use App\Forms\LogInForm;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Core\Token;

class AuthController
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly Token                   $token
    )
    {
    }

    /**
     * method to manage the login of users
     *
     * @return void
     */
    public function index()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        LogInForm::validate($input);

        $token = $this->token->generate($input['email']);

        echo response(['token' => $token], 'User logged in successfully', 200);

    }

    /**
     * method to manage the registration of users
     *
     * @return void
     * @throws \App\Exception\ValidationException
     */
    public function store()
    {

        $data = json_decode(file_get_contents('php://input'), true);

        $data = CreateSignUpForm::validate($data);

        $user = User::initiate($data);

        $user->hashPassword();

        $item = $this->userRepository->save($user);

        $token = $this->token->generate($user->email);

//        todo Dtos



        echo response(
            [
                "email" => $item->email,
                "token" => $token,
            ]
            , 'User created successfully', 201);
    }
}