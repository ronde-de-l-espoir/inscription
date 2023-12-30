<?php

require('../../db_config.php'); // connects to database

$id = file_get_contents('php://input'); // strange way of getting a POST request's body...


$sql = "SELECT COUNT(*) FROM `preinscriptions` WHERE `id`='$id';";

$xResults = mysqli_fetch_all(mysqli_query($conn, $sql))[0][0]; // number of results

header('Content-Type: text/plain');
if ($xResults != 0){
    http_response_code(405); // developer-defined response codes...I'm pretty sure that's not very good practice 🤔
} else {
    http_response_code(205);
}

?>