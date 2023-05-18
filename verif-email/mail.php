<?php 

$code = rand(10000, 99999);
setcookie('code', md5($code), time()+900, "/"); 

?>
