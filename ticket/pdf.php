<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./pdf.css">
<link rel="stylesheet" href="<?= $cssSrc ?>">

<body>
    <header style="background-image: url('<?= 'data:image/' . mime_content_type('./assets/gradient.png') . ';base64,' . base64_encode(file_get_contents('./assets/gradient.png')); ?>'); width: 100%">
        <div id="title">
            <span>Gala - Ronde de l'Espoir</span>
            <br>
            <span style="font-size: 80%;">2 juin 2023</span>
        </div>
    </header>
    <main>
        
        <div class="spacer" style="height: 50px;"></div>
        <div>
            <div>
                <div id="ticket-announcement">Ticket de préinscription n°<?= $requestID ?> pour :</div>
                <br>
                <br>
                <div id="person-info">
                    <div style="text-transform: uppercase; font-size: 1.4em"><?= $person['lname'] . " " . $person['fname'] ?></div>
                    <div><?= $person['age'] ?> ans</div>
                    <div><?= $person['email'] ?></div>
                    <div><?= $person['phone'] ?></div>
                    <br>
                    <div>Vous devrez payer <span style="font-size: 175%; font-weight: 400; text-decoration: underline;"><?= $person['price'] ?></span> € à votre entrée</div>
                </div>
                <br>
                <br>
                <?php if (count($children) > 0) : ?>
                <div id="dependents">
                    <p><?= count($children) ?> inscrits dépendant de vous :</p>
                    <ul>
                        <?php 
                        foreach ($children as $child) :
                        ?>
                        <li><span style="text-transform: uppercase;"><?= $child['lname'] . " " . $child['fname'] ?></span> qui a <?= $child['age'] ?> ans et doit payer <?= $child['price'] ?> €</li>

                        <?php endforeach ?>
                    </ul>
                </div>
                <?php endif ?>
        </div>

        <div class="center-contents">
            <img src="https://chart.googleapis.com/chart?cht=qr&chl=<?= $requestID ?>&chs=258" alt="ilage" style="width: 40%;" id="qr">
        </div>
    </main>


    <footer>
        <p>Ticket Gala La Merci Littoral - 2 juin 2023 <br> Généré par https://inscription.ronde-de-l-espoir.fr le <?= date('d-m-Y') ?> à <?= date('H:i:s') ?></p>
    </footer>
</body>

</html>