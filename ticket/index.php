<?php

require_once '../lib/dompdf/autoload.inc.php';

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
    $dompdf = new Dompdf();
    $dompdf->setOptions($options);

    // $dompdf->add_info('Title', 'Your meta title');

    // A few settings
    $image = '../ptit-bg.png';

    // Read image path, convert to base64 encoding
    $imageData = base64_encode(file_get_contents($image));

    // Format the image SRC:  data:{mime};base64,{data};
    $src = 'data:' . mime_content_type($image) . ';base64,' . $imageData;


    $css = base64_encode(file_get_contents('./pdf.css'));
    $cssSrc = 'data:' . mime_content_type('./pdf.css') . ';base64,' . $css;

    ob_start();


?>

    <!DOCTYPE html>
    <html lang="en">
    <link rel="stylesheet" href="<?= $cssSrc ?>">

    <body>
        <div id="title-block">
            <h1>La Ronde de l'Espoir</h1>
        </div>
        <img src="https://chart.googleapis.com/chart?cht=qr&chl=<?= $requestID ?>&chs=258" alt="ilage" style="width: 50%;">
    </body>

    </html>

<?php
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
    header("Content-Disposition: inline; filename=ticket.pdf");
    header("Content-Description: PDF Ticket");
    echo $pdf;
} else {
    header('Location: ../');
}
?>
<script>
  // Update the title of the page
  document.title = 'My Custom Title';
</script>