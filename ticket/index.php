<?php

require_once '../vendor/autoload.php';

// the lib used to create a PDF
use Dompdf\Dompdf;
use Dompdf\Options;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$requestID = $_GET['id']; // the id of the ticket to generate
$mode = $_GET['mode']; // more on that later

// $IDs is the list of authorized IDs whose tickets the user can access
if ($_SESSION['action'] == 'book') {
    // if /ticket is accessed after /enregistrement (so after a booking)...
    $IDs = array(
        $_SESSION['id']
    );
    foreach ($_SESSION['members']['table'] as $person) {
        array_push($IDs, $person['id']);
    }
    // the allowed IDs are the buyer's ID and all the childrens' IDs
} elseif ($_SESSION['action'] == 'lost'){
    // see /perdu
    $IDs = $_SESSION['allowed'];
}


if (in_array($requestID, $IDs)) {
    $options = new Options(); // create an options class
    $options->set('isRemoteEnabled', true); // necessary for using local assets for the PDF
    $options->set('defaultMediaType', 'all');
    $options->set('isFontSubsettingEnabled', true);
    $options->set('defaultFont', 'Helvetica');
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf(); // creates an instance of the PDF generator
    $dompdf->setOptions($options); // loads the options into the generator
    $dompdf->setBasePath($_SERVER['DOCUMENT_ROOT']); // sets the base path for local assets imports

    // $image = '../ptit-bg.png';
    // $imageData = base64_encode(file_get_contents($image));
    // $src = 'data:' . mime_content_type($image) . ';base64,' . $imageData;

    require('../modules/getDataFromSQL.php'); // gets $person, $children and $parent from the database for the specified $requestID

    $css = base64_encode(file_get_contents(__DIR__ . '/pdf.css'));
    $cssSrc = 'data:' . mime_content_type(__DIR__ . '/pdf.css') . ';base64,' . $css;
    // the only F way to get CSS to work in this lib

    ob_start();

    include(__DIR__ . '/pdf.php'); // same, don't change this !

    $dompdf->loadHtml(ob_get_clean());
    $dompdf->setPaper('A4');
    try {
        $dompdf->render(); // creates the PDF in its buffer
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $pdf = $dompdf->output(); // string-form PDF
    if ($mode == 'view'){
        // headers are needed so that the browser displays the native PDF viewer, and renders the PDF
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=gala-LRDE-{$person['fname']}-{$person['lname']}-$requestID.pdf"); // filename if the 'Download' button is clicked on the PDF viewer
        header("Content-Description: PDF Ticket");
        echo $pdf;
    } elseif ($mode == "dl"){
        $dompdf->stream("gala-LRDE-{$person['fname']}-{$person['lname']}-$requestID.pdf", array("Attachment" => true)); // downloads the PDF and closes the tab (because there are no headers, I think)
    } elseif ($mode == "raw"){
        echo $pdf; // returns the raw string (see /enregistrement for use case)
    }
} else { // if ID isn't authorized
    header('Location: ../');
}
?>