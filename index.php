<?php

// load autoloader
require 'vendor/autoload.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);




header('json: application/json');

$database = new \Core\Database();
$items= $database->query("SELECT * FROM shopping_items")->fetchAll();



echo json_encode(
    [
        'data' => $items,
        'status' => 'success',
        'message' => 'Hello, World!'
    ]
);






