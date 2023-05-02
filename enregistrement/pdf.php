<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ob_start(); 

?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./pdf.css">
<body>
    <p>hello <?= $_SESSION['fname'] . $_SESSION['lname'] ?></p>
</body>
</html>

<?php $html = ob_get_clean(); ?>
