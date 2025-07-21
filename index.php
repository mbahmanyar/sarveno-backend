<?php

// load autoloader
require 'vendor/autoload.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);




header('json: application/json');

$items= new App\Repositories\ShoppingItemRepository()->get();


echo response($items);






