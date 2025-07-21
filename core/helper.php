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


function abort(string $message, int $code = 404)
{
    http_response_code(404);
    header('Content-Type: application/json; charset=utf-8');

    return json_encode(
        [
            "code" => $code,
            'message' => $message,
            "success" => false
        ]
    );
}


function dd($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}