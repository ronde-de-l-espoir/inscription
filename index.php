<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_POST['activity'])){
        if ($_POST['activity'] == 'gala'){
            $_SESSION['activity'] = 'gala';
        } elseif ($_POST['activity'] == 'tombola'){
            $_SESSION['activity'] = 'tombola';
            header('Location: ./tombola');
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
            <p>Cette plateforme vous permettra d'acheter vos tickets pour :</p>
        </div>
        <form action="./" method="post">
            <button name="activity" id="gala-btn" value="gala">Gala</button>
            <button name="activity" id="tombola-btn" value="tombola">Tombola</button>
        </form>
    </main>
</body>
</html>