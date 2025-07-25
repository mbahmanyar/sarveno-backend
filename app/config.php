<?php

return [
    "app" => [
        "name" => $_ENV['APP_NAME'],
        "version" => $_ENV['APP_VERSION'],
        "debug" => $_ENV['APP_DEBUG'],
        "base_dir" => $_ENV['APP_BASE_DIR'],
    ],
    "database" => [
        "host" => $_ENV['DATABASE_HOST'],
        "username" => $_ENV['DATABASE_USERNAME'],
        "password" => $_ENV['DATABASE_PASSWORD'],
        "name" => $_ENV['DATABASE_NAME']
    ],

];