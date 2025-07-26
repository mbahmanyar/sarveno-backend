<?php


/** @var \Core\Router $router */


$router->get('/api/shopping-items/{id}', [\App\Controllers\ShoppingItemsController::class, 'show'], [\App\Middlewares\Authentication::class, \App\Middlewares\Authorization::class]);
$router->get('/api/shopping-items', [\App\Controllers\ShoppingItemsController::class, 'index'],
    [\App\Middlewares\Authentication::class]
);
$router->post('/api/shopping-items', [\App\Controllers\ShoppingItemsController::class, 'store'], [\App\Middlewares\Authentication::class]);
$router->put('/api/shopping-items/{id}', [\App\Controllers\ShoppingItemsController::class, 'update'], [\App\Middlewares\Authentication::class, \App\Middlewares\Authorization::class]);
$router->delete('/api/shopping-items/{id}', [\App\Controllers\ShoppingItemsController::class, 'delete'], [\App\Middlewares\Authentication::class, \App\Middlewares\Authorization::class]);
$router->patch('/api/shopping-items/{id}/toggle-check', [\App\Controllers\ToggleCheckShoppingItemsController::class, 'update'], [\App\Middlewares\Authentication::class, \App\Middlewares\Authorization::class]);


$router->post('/api/register', [\App\Controllers\AuthController::class, 'store']);
$router->post('/api/login', [\App\Controllers\AuthController::class, 'index']);
