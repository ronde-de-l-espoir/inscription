<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (
        !isset($_SESSION['lname'])
        || !isset($_SESSION['fname'])
        || !isset($_SESSION['age'])
        || !isset($_SESSION['email'])
        || !isset($_SESSION['phone'])
    ) {
        header('Location: ../informations');
    }

    $members = $_SESSION['members']['table'];
    $total = 0;

    function sumUpTotal($age) {
        global $total;
        if ($age == 'minor'){
            $total = $total + 5;
        } elseif ($age == 'major'){
            $total = $total + 10;
        }
    }

    sumUpTotal($_SESSION['age']);
    $_SESSION['price'] = $total;
    foreach($members as $member){
        sumUpTotal($member['age']);
    }


    function spaceUpID($ID){
        $part1 = str_split($ID, 5)[0];
        $part2 = str_split($ID, 5)[1];
        return $part1 . " " . $part2;
    }


    if (isset($_POST['action'])){
        if ($_POST['action'] == 'continue'){
            $_SESSION['hasConfirmed'] = true;
            header('Location: ../modalites');
        } else {
            header('Location: ../ajouter-des-proches');
        }
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
        <div id="details">
            <p id="text">Avec le détail suivant :</p>
            <div id="current-buyer">
                <p>Vous, <span class="data"><?= $_SESSION['fname'] . " " . $_SESSION['lname']; ?></span> , avec les informations suivantes :</p>
                <ul>
                    <li>Age : <span class="data"><?= $_SESSION['age'] == 'minor' ? 'mineur' : ($_SESSION['age'] == 'major' ? 'majeur' : '')  ?></span></li>
                    <li>Email : <span class="data"><?= $_SESSION['email'] ?></span></li>
                    <li>Numéro de téléphone : <span class="data"><?= $_SESSION['phone'] ?></span></li>
                    <li>Numéro de ticket : <span class="data"><?= spaceUpID($_SESSION['id']) ?></span></li>
                </ul>
            </div>
            <div id="members">
                <?php if (count($members) > 0) : ?>
                <p>Vous êtes accompagnés de :</p>
                <ul>
                <?php foreach($members as $member) : ?>
                    <li><span class="data"><?= $member['fname'] . " " . $member['lname'] ?></span> avec les information suivantes :
                        <ul>
                            <li>Age : <span class="data"><?= $member['age'] == 'minor' ? 'mineur' : ($member['age'] == 'major' ? 'majeur' : '')  ?></span></li>
                            <li>Email : <span class="data"><?= $member['email'] ?></span></li>
                            <li>Téléphone : <span class="data"><?= $member['phone'] ?></span></li>
                            <li>Numéro de ticket : <span class="data"><?= spaceUpID($member['id']) ?></span></li>
                        </ul>
                <?php endforeach ?>
                </ul>
                <?php endif ?>
            </div>
            <p id="text">Quelque chose ne va pas ?<br>Cliquer le bouton 'Retour' ci-après et corrigez les informations.</p>
        </div>

        <form action="./" method="post">
            <div id="buttons">
                <button type="submit" name="action" value="continue">Continuer</button>
                <button type="submit" name="action" value="goback">Retour</button>
            </div>
        </form>
    </main>
</body>
</html>