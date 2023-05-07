<?php

require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$requestID = $_GET['id'];
$mode = $_GET['mode'];

$IDs = array(
    $_SESSION['id']
);

if ($_SESSION['action'] == 'book') {
    foreach ($_SESSION['members']['table'] as $person) {
        array_push($IDs, $person['id']);
    }
}


if (in_array($requestID, $IDs)) {
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('defaultMediaType', 'all');
    $options->set('isFontSubsettingEnabled', true);
    $options->set('defaultFont', 'Helvetica');
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf();
    $dompdf->setOptions($options);
    $dompdf->setBasePath($_SERVER['DOCUMENT_ROOT']);

    // $image = '../ptit-bg.png';
    // $imageData = base64_encode(file_get_contents($image));
    // $src = 'data:' . mime_content_type($image) . ';base64,' . $imageData;

    require('../modules/getDataFromSQL.php');

    $css = base64_encode(file_get_contents('./pdf.css'));
    $cssSrc = 'data:' . mime_content_type('./pdf.css') . ';base64,' . $css;

    ob_start();

    include('./pdf.php');

    $dompdf->loadHtml(ob_get_clean());
    $dompdf->setPaper('A4');
    try {
        $dompdf->render();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $pdf = $dompdf->output();
    if ($mode == 'view'){
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=gala-LRDE-{$person['fname']}-{$person['lname']}-$requestID.pdf");
        header("Content-Description: PDF Ticket");
        echo $pdf;
    } elseif ($mode == "dl"){
        $dompdf->stream("gala-LRDE-{$person['fname']}-{$person['lname']}-$requestID.pdf", array("Attachment" => true)); 
    } elseif ($mode == "raw"){
        echo $pdf;
    }
} else {
    header('Location: ../');
}
?>