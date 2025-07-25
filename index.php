<?php

// load autoloader
use Core\Router;

require 'vendor/autoload.php';

const Base_DIR = __DIR__;


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
\Core\Application::bindToContainer(
    \App\Repositories\UserRepositoryInterface::class,
    new \App\Repositories\UserRepository(\Core\Application::container()->resolve(\Core\Database::class))
);

\Core\Application::bindToContainer(\Core\Token::class, new \Core\Token());

//try {
    $router = \Core\Application::container()->resolve(Router::class);
    $router->get('/api/shopping-items/{id}', [\App\Controllers\Api\ShoppingItemsController::class, 'show'], [\App\Middlewares\Authentication::class]);
    $router->get('/api/shopping-items', [\App\Controllers\Api\ShoppingItemsController::class, 'index'],
        [\App\Middlewares\Authentication::class]
    );
    $router->post('/api/shopping-items', [\App\Controllers\Api\ShoppingItemsController::class, 'store'], [\App\Middlewares\Authentication::class]);
    $router->put('/api/shopping-items/{id}', [\App\Controllers\Api\ShoppingItemsController::class, 'update'], [\App\Middlewares\Authentication::class]);
    $router->delete('/api/shopping-items/{id}', [\App\Controllers\Api\ShoppingItemsController::class, 'delete'], [\App\Middlewares\Authentication::class]);
    $router->patch('/api/shopping-items/{id}/toggle-check', [\App\Controllers\Api\ToggleCheckShoppingItemsController::class, 'update'], [\App\Middlewares\Authentication::class]);


    $router->post('/api/register', [\App\Controllers\Api\AuthController::class, 'store']);
    $router->post('/api/login', [\App\Controllers\Api\AuthController::class, 'index']);

    $router->get('/register', [\App\Controllers\Api\AuthController::class, 'create']);
    $router->get('/login', [\App\Controllers\Api\AuthController::class, 'show']);
    $router->get('/shopping-items', [\App\Controllers\ShoppingItemsController::class, 'index']);



    $response = $router->handle();


//
//} catch (Exception $e) {
//
//    if ($e instanceof \App\Exception\NotFoundException) {
//        echo abort($e->getMessage());
//        exit;
//    }
//
//    if ($e instanceof \App\Exception\ValidationException) {
//        echo abort($e->getMessage(), 422, $e->errors);
//        exit;
//    }
//
//    if ($e instanceof \App\Exception\UnauthenticatedException) {
//        echo abort($e->getMessage(), $e->getCode());
//        exit;
//    }
//
//    echo abort($e->getMessage(), $e->getCode());
//
//}






