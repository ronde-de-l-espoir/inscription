<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_POST['action'])){
        if ($_POST['action'] == 'book'){
            $_SESSION['action'] = 'book';
            header('Location: ./informations');
        } elseif ($_POST['action'] == 'cancel'){
            $_SESSION['action'] == 'cancel';
            header('Location: ./verif-email');
        } elseif ($_POST['action'] == 'view'){
            $_SESSION['action'] == 'view';
            header('Location: ./verif-email');
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
        </div>
        <form action="./" method="post">
            <button name="action" class="gala-btn" value="book">Je réserve !</button>
            <button name="action" class="gala-btn" value="lost">J'ai perdu mon ticket</button>
            <button name="action" class="gala-btn" value="cancel">Je souhaite annuler...</button>
        </form>
    </main>
</body>
</html>