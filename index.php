<?php

// load autoloader
use Core\Router;

require 'vendor/autoload.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


try {
    $router = new Router($uri, $method);
    $router->get('/^\/api\/shopping-items$/', [\App\Controllers\ShoppingItemsController::class, 'index']);
    $router->get('/^\/api\/shopping-items\/(\d+)$/', [\App\Controllers\ShoppingItemsController::class, 'show']);
    $response = $router->handle();
    echo response($response);

} catch (Exception $e) {

    if ($e instanceof \App\Exception\NotFoundException) {
        echo abort($e->getMessage());
        return;
    }

    echo abort($e->getMessage(), $e->getCode());

}






