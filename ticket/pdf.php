<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./pdf.css">
<link rel="stylesheet" href="<?= $cssSrc ?>">

<body>
    <header style="background-image: url('<?= 'data:image/' . mime_content_type('./assets/gradient.png') . ';base64,' . base64_encode(file_get_contents('./assets/gradient.png')); ?>'); width: 100%;">
        <div id="title">
            <span>Gala - Ronde de l'Espoir</span>
            <br>
            <span style="font-size: 80%;">2 juin 2023</span>
        </div>
    </header>
    <footer>
        <p>Ticket Gala La Merci Littoral - 2 juin 2023 <br> Généré par https://inscription.ronde-de-l-espoir.fr le <?= date('d-m-Y') ?> à <?= date('H:i:s') ?></p>
    </footer>

    <main>

        <div class="row">
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
        </div>

        <div class="center-contents row">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= $requestID ?>" alt="ilage" style="" id="qr">
        </div>

        <div style="height: 1cm;"></div>

        <div class="row">
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
            <?php 
                endif;
                if (count($parent) > 0) :
            ?>
                <div id="parents">
                    <p style="font-size: 120%;">Vous dépendez de : <span style="text-transform: uppercase;"><?= $parent['lname'] . " " . $parent['fname'] ?></span></p>
                </div>
            <?php endif ?>

        </div>


        <?php if (count($children) > 0) : ?>
        <div id="info" style="width: 81%; margin-top: 2cm">
            <p>Si les membres précédents n'ont pas leur ticket, ils doivent impérativement rentrer avec vous; le cas échéant ils ne seront pas admis.</p>
            <p>Lors de votre entrée :</p>
            <ul>
                <li>Il y aura 2 files d'attente :
                    <ol>
                        <li>Pour les préinscits : cette file sera prioritaire, merci de vous y placer quand le gala sera annoncé.</li>
                        <li>Pour les autres : si des places sont restantes ou <i>des inscrits ne sont pas présents après 15 minutes</i>, nous ferons rentrer ces personnes.</li>
                    </ol>
                </li>
                <li>Le personnel scannera le QR code ci-dessus. Merci de le tenir prêt en papier ou sur votre smartphone.</li>
                <li>Le personnel vous demandera si vous souhaitez payer pour un des membres ci-dessus :
                    <ul>
                        <li>les membres pour lequels vous payez n'auront pas à payer lors de leur entrée (ils devront tout de même présenter leur ticket)</li>
                        <li>les membres pour lequels nous <i>ne payez pas</i> devront payer leur entrée</li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php endif ?>

        <?php if(count($parent) > 0) : ?>
        
        <div id="info" style="width: 81%; margin-top: 2cm; font-size: 80%;">
            <p>Lors de votre entrée :</p>
            <ul>
                <li>Il y aura 2 files d'attente :
                    <ol>
                        <li>Pour les préinscits : cette file sera prioritaire, merci de vous y placer quand le gala sera annoncé.</li>
                        <li>Pour les autres : si des places sont restantes ou <i>des inscrits ne sont pas présents après 15 minutes</i>, nous ferons rentrer ces personnes.</li>
                    </ol>
                </li>
                <li>Le personnel scannera le QR code ci-dessus. Merci de le tenir prêt en papier ou sur votre smartphone.</li>
                <li>Il se peut que la personne dont vous dépendez ait déjà payé pour vous lors de leur entrée. Dans ce cas, vous n'aurez pas à payer.</li>
            </ul>
        </div>

        <?php endif ?>
    </main>

</body>

</html>