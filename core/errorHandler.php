<?php


set_error_handler(function ($severity, $message, $file, $line) {
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function ($e) {
    handleException($e);
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        // Handle fatal errors
        handleException(new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']));
    }
});
