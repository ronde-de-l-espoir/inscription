<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$string = file_get_contents('php://input');
$info = json_decode($string, true);

$_SESSION['members'] = $info;

http_response_code(205);
exit();

?>