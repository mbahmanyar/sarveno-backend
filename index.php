<?php

// load autoloader
use Core\Router;

require 'vendor/autoload.php';

const BASE_DIR = __DIR__;

require path('core/errorHandler.php');

(\Dotenv\Dotenv::createImmutable(BASE_DIR))->load();


$container = new \Core\Container();
\Core\Application::setContainer($container);

require_once path("/app/providers.php");


$router = \Core\Application::container()->resolve(Router::class);

require path("/app/routes.php");

$response = $router->handle();







