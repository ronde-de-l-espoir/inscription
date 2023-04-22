<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>



<!DOCTYPE html>
<html lang="en" unblur>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRDE -- Inscription</title>
    <link rel="stylesheet" href="../common.css">
    <link rel="stylesheet" href="./ajouter-des-proches.css">
    <link rel="stylesheet" href="../modules/fields/fields.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- <script type="text/javascript">
        const age = <?php echo $_SESSION['age'] ?>
    </script>
    <script src="./price.js" defer></script> -->
    <script src="./family.js" defer></script>
</head>
<body unblur>
    <?php
        $prefix = "../";
        include('../modules/nav/nav.php');
    ?>

    <main unblur>
        <h2>Ajouter des proches</h2>
        <p id="info">Cette page est facultative, vous pouvez continuer si vous le souhaitez</p>
        <div id="general-form" unblur>
            <p>Liste des personnes inscrites :</p>
            <div id="members">
                <div class="person" id="current-buyer">
                    <span><?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?> (Vous)</span>
                    <div id="actions">
                        <span class="material-symbols-rounded edit">edit</span>
                        <span class="material-symbols-rounded delete">delete_forever</span>
                    </div>
                </div>
            </div>
            <div id="add-member" onclick="addPersonBlock(this)">
                <span class="material-symbols-outlined add-person">person_add</span>
                <span>Ajouter quelqu'un</span>
            </div>
            <!-- <p>Venez avec de votre petit•e frère/sœur, et faites-lui économiser jusqu'à 5€ !</p>
            <label><input type="checkbox" name="withSibling" value="true" oninput="updateTotal()">Oui, je souhaite l'accompagner !</label>

            <div id="final-price">
                Votre prix total est : 
                <span id="total"></span>
            </div> -->

            <form id="member-info-form" unblur class="hidden">
                <div class="field" unblur>
                    <input type="text" name="lname" value="" placeholder=" " unblur>
                    <span class="placeholder" unblur>Nom</span>
                    <!-- <p class="error-text"><?php // echo array_key_exists('lname', $fieldErrors) ? $fieldErrors['lname'] : '' ?></p> -->
                </div>
                <div class="field" unblur>
                    <input type="text" name="fname" value="" placeholder=" " unblur>
                    <span class="placeholder" unblur>Prénom</span>
                    <!-- <p class="error-text"><?php // echo array_key_exists('lname', $fieldErrors) ? $fieldErrors['lname'] : '' ?></p> -->
                </div>
                <div class="field" unblur>
                    <input type="text" name="age" value="" placeholder=" " unblur>
                    <span class="placeholder" unblur>Age</span>
                    <!-- <p class="error-text"><?php // echo array_key_exists('lname', $fieldErrors) ? $fieldErrors['lname'] : '' ?></p> -->
                </div>
            </form>
        </div>
    </main>
</body>
</html>