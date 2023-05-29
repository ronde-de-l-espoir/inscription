<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require '../db_config.php';
    $sql = "SELECT * FROM `preinscriptions` WHERE `eventInfo`!='Test'";
    $result = mysqli_query($conn, $sql);
    $placesLeft = 250 - mysqli_num_rows($result);

    if (isset($_POST['action'])){
        if ($_POST['action'] == 'book'){
            $_SESSION['action'] = 'book';
            header('Location: ./informations');
        } elseif ($_POST['action'] == 'lost'){
            $_SESSION['action'] = 'lost';
            header('Location: ./verif-email');
        } elseif ($_POST['action'] == 'cancel'){
            $_SESSION['action'] = 'cancel';
            header('Location: ./cancel');
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRDE -- Inscription</title>
    <link rel="stylesheet" href="./common.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        $prefix = "./";
        include('./modules/nav/nav.php');
    ?>

    <main>
        <div id="welcome">
            <h2>Bonjour !</h2>
            <p>Cette plateforme vous permet de vous préinscrire pour le Gala du 2 juin 2023</p>
            <p>Dépêchez-vous ! Il ne reste que <span id="placesLeft"><?= $placesLeft ?></span> places !</p>
        </div>
        <form action="./" method="post">
            <?php if ($placesLeft > 0) : ?>
            <button name="action" class="gala-btn" value="book">Je réserve !</button>
            <?php endif ?>
            <button name="action" class="gala-btn" value="lost">J'ai perdu mon ticket</button>
            <!-- <button name="action" class="gala-btn" value="cancel">Je souhaite annuler...</button> -->
        </form>
        <p style="text-align: center;">Vous rencontrz un problème ?<br>Nos adresses mail sont disponibles <a href="https://ronde-de-l-espoir.fr/contact" target="_blank">ici</a></a></p>
    </main>
</body>
</html>