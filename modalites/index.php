<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['hasConfirmed']) || !$_SESSION['hasConfirmed']){
    header('Location: ../confirmation');
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'continue') {
        $_SESSION['hasReadModalites'] = true;
        header('Location: ../enregistrement');
    } else {
        header('Location: ../confirmation');
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRDE -- Récapitulatif</title>
    <link rel="stylesheet" href="../common.css">
    <link rel="stylesheet" href="./modalites.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="./modalites.js" defer></script>
</head>

<body>
    <?php
    $prefix = "../";
    include('../modules/nav/nav.php');
    ?>

    <main>
        <h2>Modalités</h2>

        <p id="text">Merci de lire ce texte attentivement.</p>
        <p>A la page suivante, les tickets d'entrée seront générés.</p>
        <p>Ils seront tous envoyés à <i>votre</i> adresse email (<span><?= $_SESSION['email'] ?></span>)</p>
        <p>Les membres inscrits à la page précédente recevrons par email <i>leur</i> ticket.</p>
        <p>Si les membres n'ont pas leur ticket, ils doivent impérativement rentrer avec vous; le cas échéant ils ne seront pas admis.</p>
        <p>Lors de votre entrée :</p>
        <ul>
            <li>Placez-vous dans la file d'attente dès 19h30 : à 20h, nous ferons rentrer des non-préinscrits</li>
            <li>Le personnel scannera le QR code présent sur votre ticket. Merci de le tenir visible en papier ou sur votre smartphone.</li>
            <li>Si des membres ont été inscrits à la page précédente, alors le personnel vous demandera pour quel membre vous souhaitez payer :
                <ul>
                    <li>les membres pour lequels vous payez n'auront pas à payer lors de leur entrée (ils devront tout de même présenter leur ticket)</li>
                    <li>les membres pour lequels nous <i>ne payez pas</i> devront payer leur entrée</li>
                </ul>
            </li>
        </ul>
        <br>
        <br>

        <form action="./" method="post">
            <div id="confirmation-input">
                <label>
                    <input type="checkbox" name="anonymous" value="1" onclick="toggleSubmit(this)">
                    <span id="chkbx-text">Je reconnais avoir pris connaissance de ces conditions.</span>
                </label>
            </div>
            <div id="buttons">
                <button type="submit" name="action" value="continue" disabled>Valider</button>
                <button type="submit" name="action" value="goback">Retour</button>
            </div>
        </form>
    </main>
</body>

</html>