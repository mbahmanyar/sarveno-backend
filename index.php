<?php

// load autoloader
use Core\Router;

require 'vendor/autoload.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


$router = new Router($uri, $method);

$router->get('/^\/api\/shopping-items$/', [\App\Controllers\ShoppingItemsController::class, 'index']);

$router->get('/^\/api\/shopping-items\/(\d+)$/', [\App\Controllers\ShoppingItemsController::class, 'show']);

$check = $router->handle();


$items = new App\Repositories\ShoppingItemRepository()->get();


echo response($items);






