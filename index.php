<?php

// load autoloader
require 'vendor/autoload.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$connection = new PDO('mysql:host=localhost;dbname=sarveno', 'root', 'Meb@6057720');

$statement = $connection->prepare("SELECT * FROM shopping_items");
$statement->execute();

$items = $statement->fetchAll(PDO::FETCH_ASSOC);


header('json: application/json');



echo json_encode(
    [
        'data' => $items,
        'status' => 'success',
        'message' => 'Hello, World!'
    ]
);






