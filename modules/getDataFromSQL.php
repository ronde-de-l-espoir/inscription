<?php

/**
 * Returns all the information about a specified ID
 * Including parent node and all the children nodes
 * The script will always return $person, $children, $parent, even if they are empty to allow for looping in caller scripts
 */

require('../../db_config.php'); // connects to database
$personSQL = "SELECT * FROM `preinscriptions` WHERE `id`='$requestID'";
$personResult = mysqli_query($conn, $personSQL);
$person = mysqli_fetch_assoc($personResult); // converts result into an associative array, similar to dicts in Python

if ($person['nChildren'] > 0){
    $childrenSQL = "SELECT * FROM `preinscriptions` WHERE `parentNode`='$requestID'"; // queries the database for the list of children
    $childrenResult = mysqli_query($conn, $childrenSQL);
    $result = $conn->query($childrenSQL);
    $children = array();
    while($child = $result->fetch_assoc()) {
        $children[] = $child;
    }
} else {
    $children = array(); // empty array
}

if ($person['parentNode'] != '' && $person['parentNode'] != '0'){ // backwards compatibility where parentIDs where saved as empty strings
    $parentID = $person['parentNode'];
    $parentSQL = "SELECT * FROM `preinscriptions` WHERE `id`='$parentID'"; // gets the one and only parent node
    $parentResult = mysqli_query($conn, $parentSQL);
    $parent = mysqli_fetch_assoc($parentResult);
} else {
    $parent = array(); // empty array
}

?>