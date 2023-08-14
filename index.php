<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require '../db_config.php';
    $sql = "SELECT * FROM `preinscriptions` WHERE `eventInfo`!='Test'"; // this sql gets all rows from the db preinscriptions if the eventInfo column is different than 'Test' (the normal value is 'Gala')
    $result = mysqli_query($conn, $sql);
    $placesLeft = 250 - mysqli_num_rows($result); // counts the number of rows and deducts it from a set max number of people

    if (isset($_POST['action'])){
        // 'action' will become a very broad SESSION var : it defines the global action you want to achieve using the site
        if ($_POST['action'] == 'book'){
            $_SESSION['action'] = 'book';
            header('Location: ./informations'); // if the user wants to book (clicked the button 'book' below), send him to ./informations
        } elseif ($_POST['action'] == 'lost'){
            $_SESSION['action'] = 'lost';
            header('Location: ./verif-email'); // if the user wants to recover a lost ticket (clicked the button 'lost' below), send him to ./verif-email
        } elseif ($_POST['action'] == 'cancel'){
            $_SESSION['action'] = 'cancel'; // THIS SECTION HASN'T BEEN DONE, PLEASE BUILD CANCELLATION
            header('Location: ./cancel'); // if the user wants to cancel (clicked the button 'cancel' below), send him to ./cancel
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
        $prefix = "./"; // this allows the below nav to access css and images easily
        include('./modules/nav/nav.php'); // includes the nav
    ?>

    <main>
        <div id="welcome">
            <h2>Bonjour !</h2>
            <p>Cette plateforme vous permet de vous préinscrire pour le Gala du 2 juin 2023</p>
            <p>Dépêchez-vous ! Il ne reste que <span id="placesLeft"><?= $placesLeft ?></span> places !</p>
            <!-- shows how many places are left -->
        </div>
        <form action="./" method="post">
            <?php if ($placesLeft > 0) : // only shows the book option if the number of places is greater than 0 ?>
            <button name="action" class="gala-btn" value="book">Je réserve !</button>
            <?php endif ?>
            <button name="action" class="gala-btn" value="lost">J'ai perdu mon ticket</button>
            <!-- <button name="action" class="gala-btn" value="cancel">Je souhaite annuler...</button> -->
            <!-- Cancel button is commented because it hasn't been done -->
        </form>
    </main>
</body>
</html>