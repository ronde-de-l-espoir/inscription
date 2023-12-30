<main>
    <p>Bonjour <span><?= $person['fname'] . " " . $person['lname'] ?> !</span></p> <!-- name -->

    <?php if (array_key_exists('id', $parent)) : ?> <!-- if a parent node exists for this node -->
    
        <p>Votre proche <span><?= $parent['fname'] . " " . $parent['lname'] ?></span> vous a préinscrit pour le gala du lycée La Merci Littoral qui aura lieu à l'occasion de la Ronde de l'Espoir, le vendredi 2 juin à 19 heures.</p>
        <p>Vous trouverez ci-joint votre billet d'entrée.</p>

    <?php elseif (count($children) > 0) : ?> <!-- a child node cannot have children -->

        <p>Vous avez réservé des tickets pour le gala du lycée La Merci Littoral qui aura lieu à l'occasion de la Ronde de l'Espoir, le vendredi 2 juin à 19 heures, pour les personne suivantes :
            <ul>
                <li>Vous</li>
                <?php foreach ($children as $child) : ?> <!-- lists all the children nodes' names -->
                <li><?= $child['fname'] . " " . $child['lname'] ?></li>
                <?php endforeach ?>
            </ul>
        </p>
        <p>Vous trouverez ci-joint les billets d'entrée pour tous ces <?= count($children) + 1 ?> personnes.</p>

    <?php else : ?> <!-- simple lonely person case -->

        <p>Vous avez réservé une place pour le gala du lycée La Merci Littoral qui aura lieu à l'occasion de la Ronde de l'Espoir, le vendredi 2 juin à 19 heures.</p>
        <p>Vous trouverez votre billet d'entrée en pièce-jointe.</p>

    <?php endif ?>

    <p>Bien cordialement,<br>L'équipe de la Ronde de l'Espoir</p> <!-- Politeness is the art of choosing among one's real thoughts -->
</main>