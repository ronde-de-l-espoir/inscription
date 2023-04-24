<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$string = file_get_contents('php://input');
$info = json_decode($string, true);

$_SESSION['members'] = $info;


header('Content-Type: text/plain');
echo "ok";
exit();

?>