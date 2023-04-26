<?php

require('../../galaDBConfig.php');

$id = file_get_contents('php://input');


$sql = "SELECT COUNT(*) FROM `preinscriptions` WHERE `id`='$id';";

$xResults = mysqli_fetch_all(mysqli_query($conn, $sql))[0][0];

header('Content-Type: text/plain');
if ($xResults != 0){
    http_response_code(405);
} else {
    http_response_code(205);
}

?>