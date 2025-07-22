<?php

// load autoloader
use Core\Router;

require 'vendor/autoload.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$container = new \Core\Container();

\Core\Application::setContainer($container);

\Core\Application::bindToContainer(\Core\Database::class, new \Core\Database());
\Core\Application::bindToContainer(\Core\Router::class, new \Core\Router($uri, $method));
\Core\Application::bindToContainer(
    \App\Repositories\ShoppingItemRepository::class,
    new \App\Repositories\ShoppingItemRepository(\Core\Application::container()->resolve(\Core\Database::class))
);

try {
    $router = \Core\Application::container()->resolve(Router::class);
    $router->get('/^\/api\/shopping-items$/', [\App\Controllers\ShoppingItemsController::class, 'index']);
    $router->get('/^\/api\/shopping-items\/(\d+)$/', [\App\Controllers\ShoppingItemsController::class, 'show']);
    $router->post('/^\/api\/shopping-items$/', [\App\Controllers\ShoppingItemsController::class, 'store']);
    $router->put('/^\/api\/shopping-items\/(\d+)$/', [\App\Controllers\ShoppingItemsController::class, 'update']);
    $router->delete('/^\/api\/shopping-items\/(\d+)$/', [\App\Controllers\ShoppingItemsController::class, 'delete']);


    $response = $router->handle();


} catch (Exception $e) {

    if ($e instanceof \App\Exception\NotFoundException) {
        echo abort($e->getMessage());
        return;
    }

    echo abort($e->getMessage(), $e->getCode());

}






