<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    $fieldErrors = [];

    if (isset($_POST['action'])){
        
        foreach ($_POST as $key => $fieldValue) {
            $_SESSION[$key] = $fieldValue;
            $fieldErrors[$key] = '';
        }

        if ($_POST['action'] == 'goback'){
            header('Location: ../');
        } elseif ($_POST['action'] == 'continue'){
            
            if (empty($_SESSION['lname'])){
                $fieldErrors['lname'] = 'Un nom est requis';
            } elseif (!preg_match('/^[a-zA-Z]+$/', $_SESSION['lname'])){
                $fieldErrors['lname'] = 'Nom non valide';
            } else {
                $fieldErrors['lname'] = '';
                $fieldErrors['total'] = false;
            }
            if (empty($_SESSION['fname'])){
                $fieldErrors['fname'] = 'Un prénom est requis';
            } elseif (!preg_match('/^[a-zA-Z]+$/', $_SESSION['fname'])){
                $fieldErrors['fname'] = 'Prénom non valide';
            } else {
                $fieldErrors['fname'] = '';
                $fieldErrors['total'] = false;
            }
            if ($_SESSION['activity'] == 'gala'){
                if (empty($_SESSION['age'])){
                    $fieldErrors['age'] = 'Un age est requis';
                } elseif (!(intval($_SESSION['age']) > 11 && intval($_SESSION['age'] < 100))){
                    $fieldErrors['age'] = 'Age non valide';
                } else {
                    $fieldErrors['age'] = '';
                    $fieldErrors['total'] = false;
                }
            }
            if (empty($_SESSION['email'])){
                $fieldErrors['email'] = 'Un email est requis';
            } elseif (!filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)){
                $fieldErrors['email'] = 'Email non valide';
            } else {
                $fieldErrors['email'] = '';
                $fieldErrors['total'] = false;
            }
            if (empty($_SESSION['phone'])){
                $fieldErrors['phone'] = 'Un téléphone est requis';
            } elseif (!preg_match('/^(0|(\+33[\s]?([0]?|[(0)]{3}?)))[1-9]([-. ]?[0-9]{2}){4}$/', $_SESSION['phone'])){
                $fieldErrors['phone'] = 'Téléphone non valide';
            } else {
                $fieldErrors['phone'] = '';
                $fieldErrors['total'] = false;
            }


            if ($fieldErrors['total'] == false){
                $_SESSION['infoErrors'] = false;
                if ($_SESSION['activity'] == 'gala'){
                    header('Location: ../options-gala');
                } else {
                    header('Location: ../paiement');
                }

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
                    <input type="text" name="lname" value="<?php echo $_SESSION['lname'] ?>">
                    <span class="placeholder">Nom</span>
                    <p class="error-text"><?php echo array_key_exists('lname', $fieldErrors) ? $fieldErrors['lname'] : '' ?></p>
                </div>
                <div class="field">
                    <input type="text" name="fname" value="<?php echo $_SESSION['fname'] ?>">
                    <span class="placeholder">Prénom</span>
                    <p class="error-text"><?php echo array_key_exists('fname', $fieldErrors) ? $fieldErrors['fname'] : '' ?></p>
                </div>
                <?php if ($_SESSION['activity'] == 'gala') : ?>
                <div class="field">
                    <input type="number" name="age" min="0" value="<?php echo $_SESSION['age']?>">
                    <span class="placeholder">Age</span>
                    <p class="error-text"><?php echo array_key_exists('age', $fieldErrors) ? $fieldErrors['age'] : '' ?></p>
                </div>
                <?php endif; ?>
            </div>
            <div id="separator" style="background-color: #888;"></div>
            <div class="column">
                <div class="field">
                    <input type="text" name="email" value="<?php echo $_SESSION['email'] ?>">
                    <span class="placeholder">Email</span>
                    <p class="error-text"><?php echo array_key_exists('email', $fieldErrors) ? $fieldErrors['email'] : '' ?></p>
                </div>
                <div class="field">
                    <input type="text" name="phone" value="<?php echo $_SESSION['phone'] ?>">
                    <span class="placeholder">Téléphone</span>
                    <p class="error-text"><?php echo array_key_exists('phone', $fieldErrors) ? $fieldErrors['phone'] : '' ?></p>
                </div>
            </div>
            <div id="buttons">
                <button type="submit" name="action" value="goback">Retour</button>
                <button type="submit" name="action" value="continue">Continuer</button>
            </div>
        </form>
    </main>
</body>
</html>