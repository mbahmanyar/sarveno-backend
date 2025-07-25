<?php

namespace App\Middlewares;

use App\Repositories\UserRepositoryInterface;
use Core\Application;
use Core\Interfaces\AuthenticationInterface;
use Core\Interfaces\MiddlewareInterface;
use Core\Token;

class Authentication implements MiddlewareInterface
{

    public function __construct(
        private Token $token,
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    public function handle()
    {
        $token = $this->token->extractTokenFromHeader();

        if (!$token || !($payload = $this->token->verify($token))) {
            throw new \App\Exception\UnauthenticatedException("Token not provided", 401);
        }

        $email = $payload->sub;

        $currentUser = $this->userRepository->findByEmail($email);

        if (!$currentUser) {
            throw new \App\Exception\UnauthenticatedException("User not found", 404);
        }

        Application::bindToContainer(AuthenticationInterface::class, $currentUser);
    }
}