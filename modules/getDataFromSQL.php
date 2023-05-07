<?php
require('../../db_config.php');
$personSQL = "SELECT * FROM `preinscriptions` WHERE `id`='$requestID'";
$personResult = mysqli_query($conn, $personSQL);
$person = mysqli_fetch_assoc($personResult);

if ($person['nChildren'] > 0){
    $childrenSQL = "SELECT * FROM `preinscriptions` WHERE `parentNode`='$requestID'";
    $childrenResult = mysqli_query($conn, $childrenSQL);
    $result = $conn->query($childrenSQL);
    $children = array();
    while($child = $result->fetch_assoc()) {
        $children[] = $child;
    }
} else {
    $children = array();
}

if ($person['parentNode'] != '' && $person['parentNode'] != '0'){
    $parentID = $person['parentNode'];
    $parentSQL = "SELECT * FROM `preinscriptions` WHERE `id`='$parentID'";
    $parentResult = mysqli_query($conn, $parentSQL);
    $parent = mysqli_fetch_assoc($parentResult);
} else {
    $parent = array();
}

?>