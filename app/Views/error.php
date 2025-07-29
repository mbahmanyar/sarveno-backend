<?php

$headers = getallheaders();
$code = http_response_code();

?>
<?php require view_path("Shares/head.php"); ?>
<?php require view_path("Shares/open_body.php"); ?>


<div id="error">

    <p class="error-message">
        <?= match ($code) {
            404 => "Page not found.",
            403 => "You are not authorized to access this page.",
            500 => "Internal server error.",
            422 => "Validation error occurred.",
            default => "An error occurred. Please try again later."
        } ?>
    </p>

    <p class="error-code">
        <?= "Error Code: " . $code ?>
    </p>

    <a class="sub-link" href="/login">back to login page</a>


</div>


<?php require view_path("Shares/close_body.php"); ?>
