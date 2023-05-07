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
    $personEmail = $person['email'];
    $personPhone = $person['phone'];
    $personHasPaid = 0;
    $personParentNode = $buyerID;
    $personNChildren = '0';
    $sql = "INSERT INTO preinscriptions(id, fname, lname, age, email, phone, price, hasPaid, parentNode, nChildren) VALUES(
        '$personID',
        '$personFname',
        '$personLname',
        '$personAge',
        '$personEmail',
        '$personPhone',
        '$personPrice',
        '$personHasPaid',
        '$personParentNode',
        '$personNChildren'
    )";
    mysqli_query($conn, $sql);
}


$_GET['mode'] = 'raw';
$tickets = array();

$_GET['id'] = $buyerID;
ob_start();
include '../ticket/index.php';
$ticket = array (
    'id' => $buyerID,
    'pdf' => ob_get_clean(),
);
$tickets[0] = $ticket;

$i = 1;
foreach ($_SESSION['members']['table'] as $person){
    $_GET['id'] = $person['id'];
    ob_start();
    include '../ticket/index.php';
    $ticket = array (
        'id' => $person['id'],
        'pdf' => ob_get_clean(),
    );
    $tickets[$i] = $ticket;
    $i++;
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./enregistrement.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <?php
    $prefix = "../";
    include('../modules/nav/nav.php');
    ?>

    <main>
        <h2>Terminé !</h2>
        <p>Les tickets sont disponibles ci-dessous.</p>
        <p>Vous pouvez les visionner en cliquant sur <span class="material-symbols-rounded" style="vertical-align: text-bottom;">visibility</span> ou les télécharger directement en cliquant sur <span class="material-symbols-rounded" style="vertical-align: text-bottom;">download</span></p>
        <div id="tickets">
            <div class="ticket">
                <span><?= "gala-LRDE-" . $_SESSION['fname'] . "-" . $_SESSION['lname'] . "-" . $_SESSION['id'] . ".pdf" ?></span>
                <div class="actions">
                    <a href="../ticket/view/<?= $_SESSION['id'] ?>" target="_blank" style="color: inherit;"><span class="material-symbols-rounded">visibility</span></a>
                    <a href="../ticket/dl/<?= $_SESSION['id'] ?>" target="_blank" style="color: inherit;"><span class="material-symbols-rounded">download</span></a>
                </div>
            </div>
            <?php foreach ($_SESSION['members']['table'] as $member) : ?>
            
            <div class="ticket">
                <span><?= "gala-LRDE-" . $member['fname'] . "-" . $member['lname'] . "-" . $member['id'] . ".pdf" ?></span>
                <div class="actions">
                    <a href="../ticket/view/<?= $member['id'] ?>" target="_blank" style="color: inherit;"><span class="material-symbols-rounded">visibility</span></a>
                    <a href="../ticket/dl/<?= $member['id'] ?>" target="_blank" style="color: inherit;"><span class="material-symbols-rounded">download</span></a>
                </div>
            </div>

            <?php endforeach ?>
        </div>
    
    </main>
</body>

</html>