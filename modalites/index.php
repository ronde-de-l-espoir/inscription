<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'continue') {
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
        <h2>Récapitulatif</h2>

        <p id="text">Merci de lire ce texte attentivement.</p>
        <p>A la page suivante, les tickets d'entrée seront générés.</p>
        <p>Ils seront envoyés à <i>votre</i> adresse email (<span><?= $_SESSION['email'] ?></span>)</p>
        <p>Si vous souhaitez que les membres inscrits à la page précédente aient leurs tickets sur eux, merci de le leur faire suivre.</p>
        <p>Si les membres n'ont pas leur ticket, ils doivent impérativement rentrer avec vous; le cas échéant ils ne seront pas admis.</p>
        <p>Lors de votre entrée :</p>
        <ul>
            <li>Il y aura 2 files d'attente :
                <ol>
                    <li>Pour les préinscits : cette file sera prioritaire, merci de vous y placer quand le gala sera annoncé.</li>
                    <li>Pour les autres : si des places sont restantes ou <i>des inscrits ne sont pas présents après 15 minutes</i>, nous ferons rentrer ces personnes.

                    </li>
                </ol>
            </li>
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