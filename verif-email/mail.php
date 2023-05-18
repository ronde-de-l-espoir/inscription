<?php 

$code = rand(10000, 99999);
setcookie('code', md5($code), time()+900, "/"); 

?>

<main style="text-align: center;font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
    <p>Bonjour,</p>
    <p>Vous avez demandé un code de confirmation pour <a href="https://inscription.ronde-de-l-espoir.fr">inscription.ronde-de-l-espoir.fr</a></p>
    <div style="width: 180px;padding: 20px 0;text-align: center;margin: 40px auto;font-size: 190%;background-color: blue;color: white;border-radius: 5px;font-weight: 100;"><?= $code ?></div>
    <p>Ce code n'est valide que pour 15 minutes<br>Passé ce délai vous devrez en générer un autre.</p>
    <p>Ce code n'est utilisable qu'une seule fois.</p>
    <p>Si vous générez un nouveau code, le précédent ne sera plus valide.</p>
    <p>Si vous rencontrez des problèmes, merci de vous assurer que les cookies soient activés.</p>
</main>