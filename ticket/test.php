<?php 

/**
 * JUST A TEST WITH THE EMAILS
 * this shouldn't be here
 */

use PHPMailer\PHPMailer\PHPMailer;


// $_GET['id'] = '481545219';
// $_GET['mode'] = 'rawpdf';

// ob_start();

// include('./index.php');

// $stuff = ob_get_clean();

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'ronde-de-l-espoir.fr';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = 'no-reply@ronde-de-l-espoir.fr';
$mail->Password = 'Delta43theta!';
$mail->SMTPSecure = "ssl";
$mail->setFrom('no-reply@ronde-de-l-espoir.fr', "Ne Pas Répondre - Ronde de l'Espoir");
$mail->Subject = 'Email Subject';
$mail->isHTML(true);
$mail->Body = '<html><body><h1>Hello, World!</h1><p>This is an HTML email.</p></body></html>';
$mail->addAddress('elias.kirkwood@gmail.com'); // you can contact me at this address if you want 🥲
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}

?>