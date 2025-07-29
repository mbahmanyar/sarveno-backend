<?php

// load autoloader
use Core\Router;

require 'vendor/autoload.php';


const BASE_DIR = __DIR__;

(\Dotenv\Dotenv::createImmutable(BASE_DIR))->load();



$container = new \Core\Container();
\Core\Application::setContainer($container);

require_once path("/app/providers.php");




//try {
    $router = \Core\Application::container()->resolve(Router::class);





    require path("/app/routes.php");

    $response = $router->handle();


//} catch (Throwable $e) {
//
//    if ($e instanceof \App\Exception\NotFoundException) {
//        echo abort($e->getMessage(), 404);
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
//    if ($e instanceof \App\Exception\UnAuthorizedException) {
//        echo abort($e->getMessage(), 403);
//        exit;
//    }
//
//    echo abort($e->getMessage());
//
//}






