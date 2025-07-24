<?php

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


function abort(string $message, int $code = 400, ?array $errors = null): string
{
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

    return json_encode(
        $array
    );

}

function dd($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}

/**
 * Return the full path of a file
 *
 * @param string $path
 * @return string
 */
function path(string $path) : string
{
    return Base_DIR . $path;
}