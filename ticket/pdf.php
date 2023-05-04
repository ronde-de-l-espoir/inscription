<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./pdf.css">
<link rel="stylesheet" href="<?= $cssSrc ?>">

<body>
    <main style="width: 100%;">
        <div style="background-image: url('<?= 'data:image/' . mime_content_type('./assets/gradient.png') . ';base64,' . base64_encode(file_get_contents('./assets/gradient.png')); ?>'); width: 100%">
            <div id="title">
                <span>Gala - Ronde de l'Espoir</span>
                <br>
                <span style="font-size: 80%;">2 juin 2023</span>
            </div>
        </div>
        <div class="spacer" style="height: 50px;"></div>
        <div>
            <div>
                <h2 id="ticket-announcement">Ticket n°<?= $requestID ?> pour :</h2>
                <h3 style="text-transform: uppercase;"><?= $person['lname'] . " " . $person['fname'] ?></h3>
                <?php if (!empty($parent)) : ?>
                <p>Child of <?= $parent['fname'] . " " . $parent['lname'] . " (email: " . $parent['email'] . ")" ?></p>
                <?php endif ?>
                <p><?php 
                    echo count($children);
                    foreach ($children as $child){
                        echo $child['fname'] . " " . $child['lname'];
                    }
                ?></p>
        </div>
        <!-- <tr>
            <td>hello</td>
            <td>hi</td>
            <td>goodbye</td>
        </tr> -->
    </table>
    
    <img src="https://chart.googleapis.com/chart?cht=qr&chl=<?= $requestID ?>&chs=258" alt="ilage" style="width: 50%;">
</body>

</html>