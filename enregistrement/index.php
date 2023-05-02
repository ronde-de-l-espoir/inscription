<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../../galaDBConfig.php');


$buyerID = $_SESSION['id'];
$buyerLname = $_SESSION['lname'];
$buyerFname = $_SESSION['fname'];
$buyerAge = $_SESSION['age'];
$buyerEmail = $_SESSION['email'];
$buyerPhone = $_SESSION['phone'];
$buyerPrice = $_SESSION['price'];
$buyerHasPaid = 0;
$buyerParentNode = '0';
$nChildren = count($_SESSION['members']['table']);


$sql = "INSERT INTO preinscriptions(id, fname, lname, age, email, phone, price, hasPaid, parentNode, nChildren) VALUES(
    '$buyerID',
    '$buyerFname',
    '$buyerLname',
    '$buyerAge',
    '$buyerEmail',
    '$buyerPhone',
    '$buyerPrice',
    '$buyerHasPaid',
    '$buyerParentNode',
    '$nChildren'
    )";

mysqli_query($conn, $sql);

foreach ($_SESSION['members']['table'] as $person) {
    $personID = $person['id'];
    $personFname = $person['fname'];
    $personLname = $person['lname'];
    $personAge = $person['age'];
    if ($personAge < 18){
        $personPrice = 5;
    } elseif ($personAge >= 18){
        $personPrice = 10;
    }
    $personHasPaid = 0;
    $personParentNode = $buyerID;
    $personNChildren = '0';
    $sql = "INSERT INTO preinscriptions(id, fname, lname, age, price, hasPaid, parentNode, nChildren) VALUES(
        '$personID',
        '$personFname',
        '$personLname',
        '$personAge',
        '$personPrice',
        '$personHasPaid',
        '$personParentNode',
        '$personNChildren'
    )";
    mysqli_query($conn, $sql);
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRDE -- Terminé</title>
    <link rel="stylesheet" href="../common.css">
    <link rel="stylesheet" href="./modalites.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="./modalites.js" defer></script>
</head>

<body>
    <?php
    $prefix = "../";
    include('../modules/nav/nav.php');
    ?>

    <main>
        <h2>Terminé !</h2>

    
    </main>
</body>

</html>