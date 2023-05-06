<?php

require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$requestID = $_GET['id'];

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

    require('../../db_config.php');
    $personSQL = "SELECT * FROM `preinscriptions` WHERE `id`='$requestID'";
    $personResult = mysqli_query($conn, $personSQL);
    $person = mysqli_fetch_assoc($personResult);

    if ($person['nChildren'] > 0){
        $childrenSQL = "SELECT * FROM `preinscriptions` WHERE `parentNode`='$requestID'";
        $childrenResult = mysqli_query($conn, $childrenSQL);
        $result = $conn->query($childrenSQL);
        $children = array();
        while($child = $result->fetch_assoc()) {
            $children[] = $child;
        }
    } else {
        $children = array();
    }
    
    if ($person['parentNode'] != '' && $person['parentNode'] != '0'){
        $parentID = $person['parentNode'];
        $parentSQL = "SELECT * FROM `preinscriptions` WHERE `id`='$parentID'";
        $parentResult = mysqli_query($conn, $parentSQL);
        $parent = mysqli_fetch_assoc($parentResult);
    } else {
        $parent = array();
    }

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

    // $dompdf->stream("gala-LRDE-$requestID.pdf", array("Attachment" => false)); 
    $pdf = $dompdf->output();
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=gala-LRDE-{$person['fname']}-{$person['lname']}-$requestID.pdf");
    header("Content-Description: PDF Ticket");
    echo $pdf;
} else {
    header('Location: ../');
}
?>