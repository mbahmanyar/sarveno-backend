<?php

use JetBrains\PhpStorm\NoReturn;

/**
 * Function to return container
 *
 * @return \Core\Interfaces\ContainerInterface
 */
function app(): \Core\Interfaces\ContainerInterface
{
    return \Core\Application::container();
}

function response(object|array $data, ?string $message = null, int $code = 200): string
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    {
        return json_encode(
            [
                'code' => $code,
                'message' => $message ?? 'Success',
                "success" => true,
                'data' => $data
            ]
        );
    };
}


#[NoReturn]
function abort(string $message, int $code = 400, ?array $errors = null): void
{
    if (responseIsJson()) {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        $array = [
            "code" => $code,
            'message' => $message,
            "success" => false
        ];

        if ($errors) {
            $array = [...$array, 'errors' => $errors];
        }
        echo json_encode(
            $array
        );

    } else {
        http_response_code($code);
        require view_path('error.php');
    }
    exit();
}

function dd($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}


/**
 * Return the full path to a file
 *
 * @param string $path
 * @return string
 */
function path(string $path): string
{
    if (!str_starts_with($path, DIRECTORY_SEPARATOR)) {
        $path = DIRECTORY_SEPARATOR . $path;
    }

    return BASE_DIR . $path;
}

/**
 * Return the full path to view folder
 *
 * @param string $path
 * @return string
 */
function view_path(string $path): string
{
    if (!str_starts_with($path, DIRECTORY_SEPARATOR)) {
        $path = DIRECTORY_SEPARATOR . $path;
    }
    return BASE_DIR . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Views' . $path;
}


/**
 * Retrieve configuration value from config file
 *
 * @param $key
 * @param $default
 * @return array|string|bool
 * @throws Exception
 */
function config($key, $default = null): array|string|bool
{
    $config = require path("app/config.php");

    if (is_null($key)) {
        throw new Exception("Key does not exist in config file.");
    }

    $key = explode('.', $key);
    $config = array_reduce($key, function ($carry, $k) use ($default) {
        if (!isset($carry[$k])) {
            return $default;
        }
        return $carry[$k];
    }, $config);

    return $config ?? $default;
}

/**
 * redirect to
 *
 * @param string $url
 * @return void
 */
#[NoReturn]
function redirect(string $url, ?int $code = 0): void
{
    header('location:' . $url, false, $code);
    exit();
}

function responseIsJson(): bool
{
    return !empty($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
}


function handleException(Throwable $e)
{

    if ($e instanceof \App\Exception\NotFoundException) {
        abort($e->getMessage(), 404);
    }
    if ($e instanceof \App\Exception\ValidationException) {
        abort($e->getMessage(), 422, $e->errors);
    }
    if ($e instanceof \App\Exception\UnauthenticatedException) {
        abort($e->getMessage(), $e->getCode());
    }
    if ($e instanceof \App\Exception\UnAuthorizedException) {
        abort($e->getMessage(), 403);
    }
    // Optionally log the $e somewhere here (file, Sentry, etc)
    abort("Internal Server Error", 500);
}

