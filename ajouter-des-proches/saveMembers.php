<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$string = file_get_contents('php://input'); // receives a JSON string as POST
$info = json_decode($string, true); // converts it to a PHP associative array

$_SESSION['members'] = $info; // saves it in session

http_response_code(205); // returns a positive response code
exit();

?>