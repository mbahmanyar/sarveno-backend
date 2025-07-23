<?php

namespace App\Middlewares;

use App\Repositories\ShoppingItemRepository;
use Core\Interfaces\AuthenticationInterface;
use Core\Interfaces\MiddlewareInterface;
use Core\Router;

class Authorization implements MiddlewareInterface
{

    public function __construct(
        private AuthenticationInterface $currentUser,
        private Router $router,
        private ShoppingItemRepository $repository
    )
    {
    }

    public function handle()
    {
        $routeParams = $this->router->getMatchedRouteParams();
        $itemId = $routeParams['id'] ?? null;

        if ($itemId) {
            $item = $this->repository->findOrFail($itemId);
            if ($item->user_id !== $this->currentUser?->id) {
                throw new \App\Exception\UnAuthorizedException("You do not have permission to access this item", 403);
            }
        }

    }
}