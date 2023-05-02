<?php

require_once '../lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$currentID = $_GET['id'];

$IDs = array (
    $_SESSION['id']
);

if ($_SESSION['action'] == 'book'){
    foreach ($_SESSION['members']['table'] as $person){
        array_push($IDs, $person['id']);
    }
}


if (in_array($currentID, $IDs)){
    
    $dompdf = new Dompdf();

    ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./pdf.css">
<body>
    <p>hello <?= $_SESSION['fname'] . $_SESSION['lname'] ?></p>
</body>
</html>

<?php

    $dompdf->loadHtml(ob_get_clean());
    $dompdf->setPaper('A4');
    $dompdf->render();

    $dompdf->stream("hello.pdf", array("Attachment" => false));
} else {
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet">
<body>
    <p>une erreur ? pas d'accès à ce ticket></p>
</body>
</html>

<?php
}
?>