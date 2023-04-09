<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRDE -- Inscription</title>
    <link rel="stylesheet" href="../common.css">
    <link rel="stylesheet" href="./gala.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        $prefix = "../";
        include('../modules/nav/nav.php');
    ?>

    <main>
        <h2>Informations personnelles</h2>
        <form action="./" method="post">
            <div class="column">
                <div class="field">
                    <input type="text" name="lname">
                    <span class="placeholder">Nom</span>
                </div>
                <div class="field">
                    <input type="text" name="fname">
                    <span class="placeholder">Prénom</span>
                </div>
                <div class="field">
                    <input type="number" name="age" min="0">
                    <span class="placeholder">Age</span>
                </div>
            </div>
            <div id="separator" style="background-color: #888;"></div>
            <div class="column">
                <div class="field">
                    <input type="email" name="email">
                    <span class="placeholder">Email</span>
                </div>
                <div class="field">
                    <input type="text" name="phone">
                    <span class="placeholder">Téléphone</span>
                </div>
            </div>
            <div id="buttons">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit velit modi, aut suscipit consequuntur aspernatur tempore sint beatae id optio. Nobis autem sapiente nesciunt nisi voluptatibus dignissimos aspernatur alias cum?
            </div>
        </form>
    </main>
</body>
</html>