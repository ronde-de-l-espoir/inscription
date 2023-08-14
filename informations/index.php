<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    
    do {
        $id = strval(str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT)); // creates a random 9-digit id (this will become the ticket id)
        require('../../db_config.php');
        $sql = "SELECT COUNT(*) FROM `preinscriptions` WHERE `id`='$id';"; // gets the rows where the id is the same
        $xResults = mysqli_fetch_all(mysqli_query($conn, $sql))[0][0]; // counts the number of result rows
    } while ($xResults != 0); // if the number of rows if 0, proceed, else, generate a new id

    // this makes sure the id is unique by checking if any other db entries have the same one
    // this does not protect against 2 people booking at the same time, and they both get the same id...but that's *very* unlikely

    $_SESSION['id'] = $id;


    $fieldErrors = [];

    if (isset($_POST['action'])){
        
        foreach ($_POST as $key => $fieldValue) {
            if ($key != 'action'){
                // loops through the posted keys and saves each of them in the session (except for the current-page action)
                $_SESSION[$key] = $fieldValue;
            }

            // fieldErrors is an array containing the errors to display to user
            $fieldErrors[$key] = ''; // inits the fieldErrors key for each field
        }

        if ($_POST['action'] == 'goback'){
            header('Location: ../');
        } elseif ($_POST['action'] == 'continue'){
            
            if (empty($_SESSION['lname'])){
                $fieldErrors['lname'] = 'Un nom est requis'; // if it's empty
            } elseif (!preg_match('/^[a-zA-Z\-\s]+$/', $_SESSION['lname'])){
                $fieldErrors['lname'] = 'Nom non valide'; // if it doesn't match the regex
            } else {
                $fieldErrors['lname'] = ''; // if everything is fine
            }
            // same comments for each block below :
            if (empty($_SESSION['fname'])){
                $fieldErrors['fname'] = 'Un prénom est requis';
            } elseif (!preg_match('/^[a-zA-Z\-\s]+$/', $_SESSION['fname'])){
                $fieldErrors['fname'] = 'Prénom non valide';
            } else {
                $fieldErrors['fname'] = '';
            }
            if (empty($_SESSION['age'])){
                $fieldErrors['age'] = 'Un age est requis';
            } elseif ($_SESSION['age'] != 'minor' && $_SESSION['age'] != 'major'){
                $fieldErrors['age'] = 'Age non valide';
            } else {
                $fieldErrors['age'] = '';
            }
            if (empty($_SESSION['email'])){
                $fieldErrors['email'] = 'Un email est requis';
            } elseif (!filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)){
                $fieldErrors['email'] = 'Email non valide';
            } else {
                $fieldErrors['email'] = '';
            }
            if (empty($_SESSION['phone'])){
                $fieldErrors['phone'] = 'Un téléphone est requis';
            } elseif (!preg_match('/^(0|(\+33[\s]?([0]?|[(0)]{3}?)))[1-9]([-. ]?[0-9]{2}){4}$/', $_SESSION['phone'])){
                $fieldErrors['phone'] = 'Téléphone non valide';
            } else {
                $fieldErrors['phone'] = '';
            }

            if (empty(array_filter($fieldErrors))){ // if all the keys of $fieldErrors are ''
                header('Location: ../ajouter-des-proches');
                die();
            }
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
    <link rel="stylesheet" href="../common.css">
    <link rel="stylesheet" href="./informations.css">
    <link rel="stylesheet" href="../modules/fields/fields.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        $prefix = "../";
        include('../modules/nav/nav.php');
    ?>

    <main>
        <h2>Vos Informations personnelles</h2>
        <p id="can-add-more-people-later">Vous pourrez ajouter d'autres personnes plus tard</p>
        <form action="./" method="post">
            <div class="column">
                <div class="field">
                    <input type="text" name="lname" value="<?php echo array_key_exists('lname', $_SESSION) ? $_SESSION['lname'] : null // this sets a saved session var if it exists ?>" placeholder=" ">
                    <span class="placeholder">Nom</span>
                    <p class="error-text"><?php echo array_key_exists('lname', $fieldErrors) ? $fieldErrors['lname'] : '' // this shows the key-corresponding error ?></p>
                </div>
                <!-- same comments for all fields below -->
                <div class="field">
                    <input type="text" name="fname" value="<?php echo array_key_exists('fname', $_SESSION) ? $_SESSION['fname'] : null ?>" placeholder=" ">
                    <span class="placeholder">Prénom</span>
                    <p class="error-text"><?php echo array_key_exists('fname', $fieldErrors) ? $fieldErrors['fname'] : '' ?></p>
                </div>
                <div class="field">
                    <p>Vous êtes :</p>
                    <!-- <input type="number" name="age" min="0" value="<?php echo array_key_exists('age', $_SESSION) ? $_SESSION['age'] : null ?>" placeholder=" ">
                    <span class="placeholder">Age</span>
                    <p class="error-text"><?php echo array_key_exists('age', $fieldErrors) ? $fieldErrors['age'] : '' ?></p> -->
                    <!-- <select name="age" id="age">
                        <option value="null">Veuillez sélectionner</option>
                        <option value="minor">Mineur</option>
                        <option value="major">Majeur</option>
                    </select> -->
                    <label><input type="radio" name="age" value="minor" <?= $_SESSION['age'] == 'minor' ? 'checked' : '' ?>>Mineur</label>
                    <label><input type="radio" name="age" value="major" <?= $_SESSION['age'] == 'major' ? 'checked' : '' ?>>Majeur</label>
                </div>
            </div>
            <div id="separator" style="background-color: #888;"></div>
            <div class="column">
                <div class="field">
                    <input type="text" name="email" value="<?php echo array_key_exists('email', $_SESSION) ? $_SESSION['email'] : null ?>" placeholder=" ">
                    <span class="placeholder">Email</span>
                    <p class="error-text"><?php echo array_key_exists('email', $fieldErrors) ? $fieldErrors['email'] : '' ?></p>
                </div>
                <div class="field">
                    <input type="text" name="phone" value="<?php echo array_key_exists('phone', $_SESSION) ? $_SESSION['phone'] : null ?>" placeholder=" ">
                    <span class="placeholder">Téléphone</span>
                    <p class="error-text"><?php echo array_key_exists('phone', $fieldErrors) ? $fieldErrors['phone'] : '' ?></p>
                </div>
            </div>
            <div id="buttons">
                <button type="submit" name="action" value="continue">Continuer</button>
                <button type="submit" name="action" value="goback">Retour</button>
                <!-- the buttons are in this order so that the Enter key triggers continue and not goback -->
            </div>
        </form>
    </main>
</body>
</html>