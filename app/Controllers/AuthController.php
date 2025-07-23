<?php

namespace App\Controllers;

use App\Forms\CreateItemForm;
use App\Forms\CreateSignUpForm;
use App\Models\ShoppingItem;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class AuthController
{

    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function store()
    {

        $data = json_decode(file_get_contents('php://input'), true);

        $data = CreateSignUpForm::validate($data);

        $model = User::initiate($data);

        $item = $this->userRepository->save($model);

        echo response($item, 201);
    }

}