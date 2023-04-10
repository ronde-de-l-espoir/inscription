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
    <link rel="stylesheet" href="./options-gala.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script type="text/javascript">
        const age = <?php echo $_SESSION['age'] ?>
    </script>
    <script src="./price.js" defer></script>
</head>
<body>
    <?php
        $prefix = "../";
        include('../modules/nav/nav.php');
    ?>

    <main>
        <h2>Compléments facultatifs</h2>
        <form>
            <p>Venez avec de votre petit•e frère/sœur, et faites-lui économiser jusqu'à 5€ !</p>
            <label><input type="checkbox" name="withSibling" value="true" oninput="updateTotal()">Oui, je souhaite l'accompagner !</label>

            <div id="final-price">
                Votre prix total est : 
                <span id="total"></span>
            </div>
        </form>
    </main>
</body>
</html>