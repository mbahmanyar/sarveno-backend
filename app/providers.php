<?php

use App\Repositories\ShoppingItemRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Core\Application;
use Core\Database;
use Core\Router;

/**
 * bind database
 */
Application::bindToContainer(Database::class, new Database());

/**
 * bind router
 */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
Application::bindToContainer(Router::class, new Router($uri, $method));



/**
 * bind custom classes
 */
Application::bindToContainer(\Core\Token::class, new \Core\Token());



/**
 * bind repositories
 */
Application::bindToContainer(
    ShoppingItemRepository::class,
    new ShoppingItemRepository(Application::container()->resolve(Database::class))
);
Application::bindToContainer(
    UserRepositoryInterface::class,
    new UserRepository(Application::container()->resolve(Database::class))
);

