<?php
    session_start();
    if (isset($_POST["resettable"])) {
        $_SESSION["table_form"] = null;
        echo $_SESSION["table_form"];
        http_response_code(200);
    } else {
        http_response_code(400);
    }
?>

