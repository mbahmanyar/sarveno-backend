<?php


/** @var \Core\Router $router */

/**
 * web
 */
$router->get('/register', [\App\Controllers\RegisteredUserController::class, 'create']);
$router->get('/login', [\App\Controllers\RegisteredUserController::class, 'show']);
$router->get('/shopping-items', [\App\Controllers\ShoppingItemsController::class, 'index']);


/**
 * api
 */
$router->get('/api/shopping-items/{id}', [\App\Controllers\Api\ShoppingItemsController::class, 'show'], [\App\Middlewares\Authentication::class, \App\Middlewares\Authorization::class]);
$router->get('/api/shopping-items', [\App\Controllers\Api\ShoppingItemsController::class, 'index'],
    [\App\Middlewares\Authentication::class]
);
$router->post('/api/shopping-items', [\App\Controllers\Api\ShoppingItemsController::class, 'store'], [\App\Middlewares\Authentication::class]);
$router->put('/api/shopping-items/{id}', [\App\Controllers\Api\ShoppingItemsController::class, 'update'], [\App\Middlewares\Authentication::class, \App\Middlewares\Authorization::class]);
$router->delete('/api/shopping-items/{id}', [\App\Controllers\Api\ShoppingItemsController::class, 'delete'], [\App\Middlewares\Authentication::class, \App\Middlewares\Authorization::class]);
$router->patch('/api/shopping-items/{id}/toggle-check', [\App\Controllers\Api\ToggleCheckShoppingItemsController::class, 'update'], [\App\Middlewares\Authentication::class, \App\Middlewares\Authorization::class]);

$router->post('/api/register', [\App\Controllers\Api\AuthController::class, 'store']);
$router->post('/api/login', [\App\Controllers\Api\AuthController::class, 'index']);
