<html lang="de">
<head>

    <?php
    include("head.php")
    ?>


</head>
<body id="dashboard" data-spy="scroll" data-target="#navbar">


<script>

    window.downloadFile = function (sUrl) {

        //Message für iOS Nutzer
        if (/(iP)/g.test(navigator.userAgent)) {
            alert('Dein Gerät unterstützt kein Download von Dateien. Versuche es im Desktop Browser.');
            return false;
        }

        // Chrome oder Safari - Download via virtual link klick
        if (window.downloadFile.isChrome || window.downloadFile.isSafari) {
            var link = document.createElement('a');
            link.href = sUrl;

            if (link.download !== undefined) {
                //HTML Download Variable. Verhindert öffnen der Variablen, falls es unterstützt wird
                var fileName = sUrl.substring(sUrl.lastIndexOf('/') + 1, sUrl.length);
                link.download = fileName;
            }

            // Verschickt "Klick Event"
            if (document.createEvent) {
                var e = document.createEvent('MouseEvents');
                e.initEvent('click', true, true);
                link.dispatchEvent(e);
                return true;
            }
        }

        // File Download erzwingen
        if (sUrl.indexOf('?') === -1) {
            sUrl += '?download';

        }

        window.open(sUrl, '_self');
        return true;
    };

    window.downloadFile.isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
    window.downloadFile.isSafari = navigator.userAgent.toLowerCase().indexOf('safari') > -1;

</script>

<?php


$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID wurde nicht gefunden.');

$sqli= "SELECT datei_name FROM uploads WHERE id = '$id'";
$statement = $pdo->prepare($sqli);
$statement->execute();
$statement->setFetchMode(PDO::FETCH_ASSOC);
$dateiIdNeu = $statement->fetch();
$file = $dateiIdNeu["datei_name"];


    $var = "<script> downloadFile('./hochgeladenes/files/$file')  </script>";
    echo $var;


?>

</body>
</html>
