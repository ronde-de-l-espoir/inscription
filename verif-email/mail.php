<?php 

$code = rand(10000, 99999); // generates a random 5-digit code
setcookie('code', md5($code), time()+900, "/");
// the cookie is set to the *md5* sum of the code for security reasons
// the code cannot be found from the md5
// but the md5 of the same code is the same md5
// 🙂

?>

<!-- simple email HTML -->

<main style="text-align: center;font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
    <p>Bonjour,<br>Vous avez demandé un code de confirmation pour <a href="https://inscription.ronde-de-l-espoir.fr">inscription.ronde-de-l-espoir.fr</a></p>
    <div style="width: 180px;padding: 20px 0;text-align: center;margin: 40px auto;font-size: 190%;background-color: #0099D7;color: white;border-radius: 5px;font-weight: 100;"><?= $code ?></div>
    <p>Ce code n'est valide que pour 15 minutes<br>Passé ce délai vous devrez en générer un autre.</p>
    <p>Ce code n'est utilisable qu'une seule fois.</p>
    <p>Si vous générez un nouveau code, le précédent ne sera plus valide.</p>
    <p>Si vous rencontrez des problèmes, merci de vous assurer que les cookies soient activés.</p>
</main>