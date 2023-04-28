<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $members = $_SESSION['members']['table'];
    $total = 0;

    function sumUpTotal($age) {
        global $total;
        if ($age < 18){
            $total = $total + 5;
        } elseif ($age >= 18){
            $total = $total + 10;
        }
    }

    sumUpTotal($_SESSION['age']);
    foreach($members as $member){
        sumUpTotal($member['age']);
    }

    function spaceUpID($ID){
        $part1 = str_split($ID, 5)[0];
        $part2 = str_split($ID, 5)[1];
        return $part1 . " " . $part2;
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRDE -- Récapitulatif</title>
    <link rel="stylesheet" href="../common.css">
    <link rel="stylesheet" href="./confirmation.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        $prefix = "../";
        include('../modules/nav/nav.php');
    ?>

    <main>
        <h2>Récapitulatif</h2>
        <p>Votre total s'élève à : <span id="total"><?= $total ?></span> €</p>
        <br>
        <div id="details">
            <p>Avec le détail suivant :</p>
            <div id="current-buyer">
                Vous, <?= $_SESSION['fname'] . " " . $_SESSION['lname']; ?> , avec les informations suivantes :
                <ul>
                    <li>Age : <span class="data"><?= $_SESSION['age'] ?></span></li>
                    <li>Email : <span class="data"><?= $_SESSION['email'] ?></span></li>
                    <li>Numéro de téléphone : <span class="data"><?= $_SESSION['phone'] ?></span></li>
                    <li>Numéro de ticket : <span class="data"><?= spaceUpID($_SESSION['phone']) ?></span></li>
                </ul>
            </div>
            <div id="members">
                <p>Vous êtes accompagnés de :</p>
                <ul>
                <?php foreach($members as $member) : ?>
                    <li><span class="data"><?= $member['fname'] . " " . $member['lname'] ?></span>, qui a <span class="data"><?= $member['age'] ?></span> ans et pour numéro d'identification <span class="data"><?= spaceUpID($member['id']) ?></span></li>
                <?php endforeach ?>
                </ul>
            </div>
        </div>

        <form action="./" method="post">
            
        </form>
    </main>
</body>
</html>