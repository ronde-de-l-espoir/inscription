<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./pdf.css">
<link rel="stylesheet" href="<?= $cssSrc ?>">

<body>
    <table style="width: 100%;">
        <tr style="background-image: url('<?= 'data:image/' . mime_content_type('./assets/gradient.png') . ';base64,' . base64_encode(file_get_contents('./assets/gradient.png')); ?>'); width: 100%">
            <td id="title">La Ronde de l'Espoir</td>
        </tr>
        <tr>
            <td>Ticket du gala du vendredi 2 juin à 19h.</td>
        </tr>
        <!-- <tr>
            <td>hello</td>
            <td>hi</td>
            <td>goodbye</td>
        </tr> -->
    </table>
    
    <img src="https://chart.googleapis.com/chart?cht=qr&chl=<?= $requestID ?>&chs=258" alt="ilage" style="width: 50%;">
</body>

</html>