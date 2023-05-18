<?php

    require('../vendor/autoload.php');
    use PHPMailer\PHPMailer\PHPMailer;

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!(isset($_SESSION['emailStep']))){
        $_SESSION['emailStep'] = 1;
    }

    function sendmail($email, $conn) {
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = 'ronde-de-l-espoir.fr';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@ronde-de-l-espoir.fr';
        $mail->Password = '***REMOVED***';
        $mail->SMTPSecure = "ssl";
        $mail->setFrom('no-reply@ronde-de-l-espoir.fr', "Ne Pas Répondre - Ronde de l'Espoir");
        $mail->Subject = "Code de sécurité - Ronde de l'Espoir";
        $mail->isHTML(true);
        $SQL = "SELECT * FROM `preinscriptions` WHERE `email`='" . $email . "'";
        $result = $conn->query($SQL);
        $IDs = array();
        while($ID = $result->fetch_assoc()) {
            $IDs[] = $ID;
        }
        ob_start();
        include "./mail.php";
        $mail->Body = ob_get_clean();
        $mail->addAddress($email);
        return $mail;
    }

    if (isset($_POST['action'])){
        if ($_SESSION['emailStep'] == 1){
            if ($_POST['action'] == 'continue'){
                if (empty($_POST['email'])){
                    // $fieldErrors['email'] = 'Un email est requis';
                } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    // $fieldErrors['email'] = 'Email non valide';
                } else {
                    $fieldErrors['email'] = '';
                    $_SESSION['email'] = $_POST['email'];
                    require('../../db_config.php');
                    $SQL = "SELECT COUNT(*) FROM `preinscriptions` WHERE `email`='" . $_POST['email'] . "'";
                    if (intval(mysqli_fetch_all(mysqli_query($conn, $SQL))[0][0]) > 0 ? true : false){
                        if (!sendmail($_SESSION['email'], $conn)->send()) {
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else {
                            $_SESSION['emailStep'] = 2;
                        }
                    } else {
                        $_SESSION['emailStep'] = 2;
                    }
                }
            } elseif ($_POST['action'] == 'goback'){
                header('Location: ../');
            }
        } elseif ($_SESSION['emailStep'] == 2){
            if ($_POST['action'] == 'continue'){
                if (isset($_POST['code'])){
                    if (md5($_POST['code']) == $_COOKIE['code']){
                        header('Location: ../somewhere');
                    } else {
                        echo 'code invalide';
                    }
                } else {
                    require('../../db_config.php');
                    if (!sendmail($_SESSION['email'], $conn)->send()) {
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    }
                }
            } elseif ($_POST['action'] == 'goback'){
                $_SESSION['emailStep'] = 1;
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
            <?php if ($_SESSION['emailStep'] == 1) : ?>
            <p>Veuillez taper votre email ci-dessous</p>
            <div class="field">
                <input type="text" name="email" value="<?php echo array_key_exists('email', $_SESSION) ? $_SESSION['email'] : null ?>" placeholder=" ">
                <span class="placeholder">Email</span>
                <!-- <p class="error-text"><?php // echo array_key_exists('lname', $fieldErrors) ? $fieldErrors['lname'] : '' ?></p> -->
            </div>
            <?php elseif ($_SESSION['emailStep'] == 2) : ?>
            <p>Si vous êtes inscrits, un code de sécurité vous a été envoyé à l'adresse suivante : <?= $_SESSION['email'] ?></p>
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