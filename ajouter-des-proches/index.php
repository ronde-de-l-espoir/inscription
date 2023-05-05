<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['members'])){
        $table = $_SESSION['members']['table'];
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
    <script>
        var info = <?php echo array_key_exists('members' ,$_SESSION) && $_SESSION['members'] != null ? json_encode($_SESSION['members']) : json_encode('{"table": []}') ?>;
        if (typeof info === 'string'){
            info = JSON.parse(info)
        }
    </script>
</head>
<body unblur>
    <?php
        $prefix = "../";
        include('../modules/nav/nav.php');
    ?>

    <main unblur>
        <h2>Ajouter des proches</h2>
        <p id="line">Cette page est facultative, vous pouvez continuer si vous le souhaitez</p>
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
                <?php
                if (isset($_SESSION['members'])){
                    for ($i=0; $i < count($table); $i++) {
                        $memberID = $table[$i]['id'];
                        $fname = $table[$i]['fname'];
                        $lname = $table[$i]['lname'];
                        $block = <<<EOD
                        <div class="person" id="$memberID">
                            <span class="person-name">$fname $lname</span>
                            <div id="actions">
                                <span class="material-symbols-rounded edit" onclick="editPerson('$memberID')">edit</span>
                                <span class="material-symbols-rounded delete" onclick="removePerson('$memberID')">delete_forever</span>
                            </div>
                        </div>
                        EOD;
                        echo $block;
                    }
                }
                ?>
            </div>
            <div id="add-member" onclick="addPersonBlock()">
                <span class="material-symbols-outlined add-person">person_add</span>
                <span>Ajouter quelqu'un</span>
            </div>
            <!-- <p>Venez avec de votre petit•e frère/sœur, et faites-lui économiser jusqu'à 5€ !</p>
            <label><input type="checkbox" name="withSibling" value="true" oninput="updateTotal()">Oui, je souhaite l'accompagner !</label>

            <div id="final-price">
                Votre prix total est : 
                <span id="total"></span>
            </div> -->

            <div class="buttons">
                <button type="submit" onclick="sendData(true)" value="continue">Continuer</button>
                <button type="submit" onclick="sendData(false)" value="goback">Retour</button>
            </div>

            <p id="response-error-text"></p>

            <form id="member-info-form" unblur class="hidden" oninput="allowMemberFormContinue()" onsubmit="return false">
                <h4 unblur>Informations sur ce membre</h4>
                <div class="field" unblur>
                    <input type="text" name="lname" value="" placeholder=" " unblur>
                    <span class="placeholder" unblur>Nom</span>
                    <p class="error-text" unblur></p>
                </div>
                <div class="field" unblur>
                    <input type="text" name="fname" value="" placeholder=" " unblur>
                    <span class="placeholder" unblur>Prénom</span>
                    <p class="error-text" unblur></p>
                </div>
                <div class="field" unblur>
                    <input type="text" name="age" value="" placeholder=" " unblur>
                    <span class="placeholder" unblur>Age</span>
                    <p class="error-text" unblur></p>
                </div>
                <div class="field" unblur>
                    <input type="text" name="email" value="" placeholder=" " unblur>
                    <span class="placeholder" unblur>Email</span>
                    <p class="error-text" unblur></p>
                </div>
                <div class="field" unblur>
                    <input type="text" name="phone" value="" placeholder=" " unblur>
                    <span class="placeholder" unblur>Téléphone</span>
                    <p class="error-text" unblur></p>
                </div>
                <div class="buttons" unblur>
                    <button id="member-form-continue" type="submit" onclick="validateMemberForm()" value="continue-form" unblur disabled>Continuer</button>
                    <button type="submit" onclick="cancelMemberForm()" value="cancel-form" unblur>Annuler</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>