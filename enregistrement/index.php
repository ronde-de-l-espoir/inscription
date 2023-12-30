<?php

use PHPMailer\PHPMailer\PHPMailer; // imports the lib used to send emails

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../../db_config.php');

if (
    isset($_SESSION['id'])
    && isset($_SESSION['lname'])
    && isset($_SESSION['fname'])
    && isset($_SESSION['age'])
    && isset($_SESSION['email'])
    && isset($_SESSION['phone'])
    && isset($_SESSION['price'])
    && isset($_SESSION['hasReadModalites'])
) {

    header('Refresh: 1800; URL=../'); // will redirect to home page 3 minutes later

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1785)) { // if 1785 seconds have passed since last activity
        session_destroy();
        session_unset();
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // sets the last activity to be the current time on load

    /**
     * DB INSERTION
     */
    
    if (!isset($_SESSION['inserted']) && !$_SESSION['inserted']){ // if the data hasn't already been inserted


        $buyerID = $_SESSION['id'];
        $buyerLname = $_SESSION['lname'];
        $buyerFname = $_SESSION['fname'];
        $buyerAge = $_SESSION['age'];
        $buyerEmail = $_SESSION['email'];
        $buyerPhone = $_SESSION['phone'];
        $buyerPrice = $_SESSION['price'];
        $buyerEvent = "Gala"; // by default
        $buyerHasPaid = 0; // obvious
        $buyerParentNode = '0'; // buyer cannot have a parent
        $nChildren = count($_SESSION['members']['table']); // gets the number of children nodes
    
        //inserts the buyer's values
        $sql = "INSERT INTO preinscriptions(id, fname, lname, age, email, phone, price, hasPaid, parentNode, nChildren, eventInfo) VALUES(
            '$buyerID',
            '$buyerFname',
            '$buyerLname',
            '$buyerAge',
            '$buyerEmail',
            '$buyerPhone',
            '$buyerPrice',
            '$buyerHasPaid',
            '$buyerParentNode',
            '$nChildren',
            '$buyerEvent'
            )";
    
    
        mysqli_query($conn, $sql);
    
        foreach ($_SESSION['members']['table'] as $person) {
            // loops through each person
            $personID = $person['id'];
            $personFname = $person['fname'];
            $personLname = $person['lname'];
            $personAge = $person['age'];
            if ($personAge < 18){ // should be using variables from a conf file
                $personPrice = 5;
            } elseif ($personAge >= 18){
                $personPrice = 10;
            }
            $personEmail = $person['email'];
            $personPhone = $person['phone'];
            $personHasPaid = 0;
            $personParentNode = $buyerID; // self-explanatory
            $personNChildren = '0';
            $personEvent = "Gala"; // by default
            // insert child into DB
            $sql = "INSERT INTO preinscriptions(id, fname, lname, age, email, phone, price, hasPaid, parentNode, nChildren, eventInfo) VALUES(
                '$personID',
                '$personFname',
                '$personLname',
                '$personAge',
                '$personEmail',
                '$personPhone',
                '$personPrice',
                '$personHasPaid',
                '$personParentNode',
                '$personNChildren',
                '$personEvent'
            )";
            mysqli_query($conn, $sql);
        }
        $_SESSION['inserted'] = true;
    }

    if (!isset($_SESSION['sentEmails']) && !$_SESSION['sentEmails']){

        /**
         * TICKET GENERATION
         */

        $_GET['mode'] = 'raw'; // raw mode returns PDF as string (see /ticket/index.php)
        // as /ticket/index.php is called using 'include', and it expects its parameters in the querystring (see .htaccess), parameters are here given by defining $_GET
    
        // gets the buyer's PDF ticket
        $_GET['id'] = $buyerID;
        ob_start();
        include '../ticket/index.php';
        $buyerPDF = ob_get_clean();
    
        // loops through the children get their ticket and stores it in a dict whose stucture is 'ID -> PDF'
        $i = 0;
        $tickets = array();
        foreach ($_SESSION['members']['table'] as $person){
            $_GET['id'] = $person['id'];
            ob_start();
            include '../ticket/index.php';
            $ticket = array (
                'id' => $person['id'],
                'pdf' => ob_get_clean()
            );
            $tickets[$i] = $ticket;
            $i++;
        }

        /**
         * EMAILS
         */
    
        function createMailInterface() { // these are the common commands to all the emails that are sent; then extra personalisation comes to each
            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();
            $mail->Host = 'ronde-de-l-espoir.fr';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@ronde-de-l-espoir.fr';
            $mail->Password = 'NoReplyEmail2023!'; // urgent : get rid of password...
            $mail->SMTPSecure = "ssl";
            $mail->setFrom('no-reply@ronde-de-l-espoir.fr', "Ne Pas Répondre - Ronde de l'Espoir"); // this is how it'll appear in the user's mailbox
            return $mail;
        }
    
        function createMailBody($person, $children, $parent) { // unnecessary parameters ? if it ain't broke, don't fix it...
            ob_start();
            include "./mail.php"; // see ./mail.php
            return ob_get_clean();
        }


        // PREPARES EMAIL FOR BUYER
        $buyerMail = createMailInterface(); // the common commands
        $buyerMail->Subject = 'Vos tickets du Gala - La Merci';
        $buyerMail->isHTML(true);
        $requestID = $buyerID;
        require('../modules/getDataFromSQL.php'); // expects $requestID to be set, explains line above (see /modules/getDataFromSQL.php)
        $buyerMail->Body = createMailBody($person, $children, $parent); // returns the actual contents of the email
        $buyerMail->addAddress($buyerEmail); // address to send to
        $buyerMail->addStringAttachment($buyerPDF, "gala-LRDE-{$person['fname']}-{$person['lname']}-$requestID.pdf", 'base64', 'application/pdf'); // adds the PDF string as a base64-encoded attachment with the following name
    
        foreach ($tickets as $ticket){
            // SENDS EMAIL TO EACH CHILD
            $mail = createMailInterface(); // the common commands
            $mail->Subject = 'Vos tickets du Gala - La Merci';
            $mail->isHTML(true);
            $requestID = $ticket['id'];
            require('../modules/getDataFromSQL.php'); // expects $requestID to be set, explains line above (see /modules/getDataFromSQL.php)
            $mail->Body = createMailBody($person, $children, $parent); // returns the actual contents of the email
            $mail->addStringAttachment($ticket['pdf'], "gala-LRDE-{$person['fname']}-{$person['lname']}-$requestID.pdf", 'base64', 'application/pdf');
            $buyerMail->addStringAttachment($ticket['pdf'], "gala-LRDE-{$person['fname']}-{$person['lname']}-$requestID.pdf", 'base64', 'application/pdf'); // ????? No idea why this is here... again, if it ain't broke, don't fix it
            $mail->addAddress($person['email']);
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }
    
        if (!$buyerMail->send()) { // SENDS EMAIL TO BUYER || why now ? idk...
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    
        $_SESSION['sentEmails'] = true;
    }

} else if ($_SESSION['action'] == 'book') {
    header('Location: ../informations/');
} else {
    header('Location: ../');
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRDE -- Terminé</title>
    <link rel="stylesheet" href="../common.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./enregistrement.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="./timer.js" defer></script>
</head>

<body>
    <?php
    $prefix = "../";
    include('../modules/nav/nav.php');
    // includes thr nav
    ?>

    <main>
        <h2>Terminé !</h2>
        <p>Les tickets sont disponibles ci-dessous.</p>
        <p>Vous pouvez les visionner en cliquant sur <span class="material-symbols-rounded" style="vertical-align: text-bottom;">visibility</span> ou les télécharger directement en cliquant sur <span class="material-symbols-rounded" style="vertical-align: text-bottom;">download</span></p>
        <div id="tickets">
            <div class="ticket">
                <span><?= "gala-LRDE-" . $_SESSION['fname'] . "-" . $_SESSION['lname'] . "-" . $_SESSION['id'] . ".pdf" ?></span>
                <div class="actions">
                    <a href="../ticket/view/<?= $_SESSION['id'] ?>" target="_blank" style="color: inherit;"><span class="material-symbols-rounded">visibility</span></a>
                    <a href="../ticket/dl/<?= $_SESSION['id'] ?>" target="_blank" style="color: inherit;"><span class="material-symbols-rounded">download</span></a>
                </div>
            </div>
            <?php foreach ($_SESSION['members']['table'] as $member) : ?> <!-- creates extra blocks for each child -->
            
            <div class="ticket">
                <span><?= "gala-LRDE-" . $member['fname'] . "-" . $member['lname'] . "-" . $member['id'] . ".pdf" ?></span>
                <div class="actions">
                    <a href="../ticket/view/<?= $member['id'] ?>" target="_blank" style="color: inherit;"><span class="material-symbols-rounded">visibility</span></a>
                    <a href="../ticket/dl/<?= $member['id'] ?>" target="_blank" style="color: inherit;"><span class="material-symbols-rounded">download</span></a>
                </div>
            </div>

            <?php endforeach ?>
        </div>
        <div id="expiration">
            <p>Cette session expirera automatiquement dans <span id="time"></span> minutes.</p> <!-- see timer.js -->
            <p>Vous pourrez aller voir vos tickets avec l'option <i>J'ai perdu mon ticket</i> sur la page d'accueil</p>
        </div>
    </main>
</body>

</html>