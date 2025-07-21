<?php

function response(object|array $data): string
{
    header('Content-Type: application/json; charset=utf-8');
    {
        return json_encode(
            [
                'status' => 200,
                'message' => 'OK',
                'data' => $data
            ]
        );
    };
}