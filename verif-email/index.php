<?php

    require('../vendor/autoload.php');
    use PHPMailer\PHPMailer\PHPMailer;

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!(isset($_SESSION['emailStep']))){
        $_SESSION['emailStep'] = 1;
    } // me wanting to have a multi-page site without redirects...

    function sendmail($email) { // same idea as /enregistrement
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = 'ronde-de-l-espoir.fr';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@ronde-de-l-espoir.fr';
        $mail->Password = 'NoReplyEmail2023!'; // get rid of this password !
        $mail->SMTPSecure = "ssl";
        $mail->setFrom('no-reply@ronde-de-l-espoir.fr', "Ne Pas Répondre - Ronde de l'Espoir");
        $mail->Subject = "Code de sécurité - Ronde de l'Espoir";
        $mail->isHTML(true);
        ob_start();
        include "./mail.php";
        $mail->Body = ob_get_clean();
        $mail->addAddress($email);
        return $mail;
    }

    if (isset($_POST['action'])){
        if ($_SESSION['emailStep'] == 1){
            // EXECUTES WHEN USER IS ON FIRST PAGE
            if ($_POST['action'] == 'continue'){
                if (empty($_POST['email'])){
                    // $fieldErrors['email'] = 'Un email est requis';
                } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ // someone should get that fixed... anyone know where that's from ? anyone ?
                    // $fieldErrors['email'] = 'Email non valide';
                } else {
                    $fieldErrors['email'] = '';
                    $_SESSION['email'] = $_POST['email'];
                    require('../../db_config.php');
                    $SQL = "SELECT COUNT(*) FROM `preinscriptions` WHERE `email`='" . $_POST['email'] . "'"; // checks if that email corresponds to a booking
                    if (intval(mysqli_fetch_all(mysqli_query($conn, $SQL))[0][0]) > 0 ? true : false){ // i'm pretty sure the ternary operator isn't needed... if it ain't broke, don't fix it, as they say
                        if (!sendmail($_SESSION['email'])->send()) {
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else {
                            $_SESSION['emailStep'] = 2; // go to the next step
                        }
                    } else {
                        $_SESSION['emailStep'] = 2; // go to the next step
                    }
                }
            } elseif ($_POST['action'] == 'goback'){
                header('Location: ../');
            }
        } elseif ($_SESSION['emailStep'] == 2){
            // EXECUTES WHEN USER IS ON SECOND PAGE
            if ($_POST['action'] == 'continue'){
                if (isset($_POST['code'])){
                    // checks the code
                    if (md5($_POST['code']) == $_COOKIE['code']){ // see ./mail.php to understand this cookie
                        unset($_COOKIE['code']); 
                        setcookie('code', null, -1, '/'); // nulls the code cookie
                        if ($_SESSION['action'] == 'lost'){
                            header('Location: ../perdu'); // sends you to the page to claim your ticket
                        } elseif ($_SESSION['action'] == 'cancel'){
                            header('Location: ../annulation');
                        }
                    } else {
                        echo 'code invalide'; // bad error control
                    }
                } else {
                    if (!sendmail($_SESSION['email'])->send()) {
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    }
                }
            } elseif ($_POST['action'] == 'goback'){
                $_SESSION['emailStep'] = 1; // self-explanatory
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
    <title>LRDE -- Vérification d'email</title>
    <link rel="stylesheet" href="../common.css">
    <link rel="stylesheet" href="./verif-email.css">
    <link rel="stylesheet" href="../modules/fields/fields.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        $prefix = "../";
        include('../modules/nav/nav.php');
    ?>

    <main>
        <form action="./" method="post">
            <?php if ($_SESSION['emailStep'] == 1) : // first step : ?> 
            <p>Veuillez taper votre email ci-dessous</p>
            <div class="field">
                <input type="text" name="email" value="<?php echo array_key_exists('email', $_SESSION) ? $_SESSION['email'] : null ?>" placeholder=" ">
                <span class="placeholder">Email</span>
                <!-- <p class="error-text"><?php // echo array_key_exists('lname', $fieldErrors) ? $fieldErrors['lname'] : '' ?></p> --> <!-- I'm pretty sure that's not meant to be like that ! Still no one ? Hint : a game on Steam -->
            </div>
            <?php elseif ($_SESSION['emailStep'] == 2) : // second step : ?>
            <p>Si vous êtes inscrit, un code de sécurité vous a été envoyé à l'adresse suivante : <?= $_SESSION['email'] ?></p>
            <div class="field">
                <input type="text" name="code" value="" placeholder=" ">
                <span class="placeholder">Code de sécurité</span>
            </div>
            <?php endif ?>

            <div id="buttons">
                <button type="submit" name="action" value="continue">Continuer</button>
                <button type="submit" name="action" value="goback">Retour</button>
            </div>
        </form>
    </main>
</body>
</html>