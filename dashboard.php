<html lang="de">
<head>
    <link rel="stylesheet" href="Sonstiges/Dropzone/dropzone.css">

    <?php
    include("head.php");

    if(!isset($_SESSION['userid'])) {
        header('Location: login.php');
        // die('Bitte zuerst <a href="login.php">einloggen</a>!');
    }
    ?>


    <script>
        Dropzone.options.dzeinstellung = {
            paramName: "uploaddatei",
            maxFilesize: 2,
            dictDefaultMessage: " ",
            thumbnailHeight: 60, thumbnailWidth: 60,
            init: function(){
                this.on('complete', function(file) {
                    this.removeFile(file);
                    location.reload();
                })
            }
        };
    </script>



</head>

<body id="dashboard" data-spy="scroll" data-target="#navbar">
<?php

include("header.php");

?>
<div class="container">
    <div class="row">


<h1 id="center"> Mein FrogDrops </h1>

<!-- Uploadformular erstellen (Uploadfunktion weiter unten)-->
<!-- <form name="uploadformular" enctype="multipart/form-data" action="dashboard.php" method="post" >
    Datei: <input type="file" name="uploaddatei" size="60" maxlength="255" >
    <input type="Submit" name="submit" value="Datei hochladen">
</form> -->

        <!-- Drag and Drop Formular -->
        <div class="col-md-12">
        <div id="dzText" > Laiche deine Daten hier drin ab! </div>
        <form id="dzeinstellung" name="uploadformular" action="dashboard.php" class="dropzone"> </form>
        </div>

<?php

//Daten aus Uploads auslesen
$sqli= "SELECT * FROM uploads WHERE user_id = $userid";
$statement = $pdo->prepare($sqli);
$statement->execute();
$statement->setFetchMode(PDO::FETCH_ASSOC);
//$row = $statement->fetch();

?>

<!-- Tabelle mit Inhalten aus uploads erstellen-->

     <!-- Tabellenkopf erstellen-->
<table class="table table-hover table-responsive table-striped">

    <thead>
    <th>Dateiname</th>
    <th>Gr&ouml;ße</th>
    </thead>
    <tbody>

    <?php

    //Funktion: Byte in MB umwandeln
    $groesse = $row["groesse"];

    function umwandlung($mb){
        $mbNeu = ($mb / 1048576);
        $mbNeu = round($mbNeu, 3) . " MB";
        return $mbNeu;
    }

    //Tabellenkörper mit ausgelesenen Daten von "uploads" füllen (Nur Daten vom angemeldeten User)
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        echo "<tr>";
        echo "<td><a href='dateiAnzeigen.php?id=".$row["id"]."'> ".$row["original_name"]."  </a> </td>";

        echo "<td>" . umwandlung($groesse).  " </td>";

        echo "<td> " . '<a onclick="aendereFile(' . $row["id"] . ',\'' . $row["original_name"]. '\')">umbenennen</a>' . " </td>";

        echo "<td> " . '<a onclick="loescheFile(' . $row["id"] . ')">l&ouml;schen</a>' . " </td>";

        if ($row['freigegeben'] != NULL) {
            echo "<td><a href='dateiFreigabeBeenden.php?id=" . $row["id"] . "'>Freigabe beenden</a></td>";
            echo "<td><a onclick='zeigeLink(\"".$row['freigegeben']."\")'>Link anzeigen</a></td>";
            echo "<td><a onclick='versendeLink(\"".$row['freigegeben']."\")'>Link versenden</a></td>";
        }else {
            echo "<td><a href='dateiFreigabe.php?id=" . $row["id"] . "'> <i class=\"fa fa-unlock\" aria-hidden=\"true\"> </i> </a></td>";
            echo "<td> </td>";
            echo "<td> </td>";
        }

        echo "<td><a href='notiz.php?id=".$row["id"]."'>Notiz</a></td>";
        echo "</tr>";

        //Variable erstellen mit Gesamtgröße aller Dateien und maximale MB festlegen
        $mbGesamt += umwandlung($groesse);
        $mbMax = 50;

    }

    if ($mbGesamt > 0) {
        $prozentAnzahl = ($mbGesamt / $mbMax) * 100;
        $prozentAnzahlgerundet = round($prozentAnzahl, 0);
}
    ?>
    </tbody>
</table>



<!-- Progess Bar, als Anzeige für die aktuellen MB-Stand -->
        <?php  if ($mbGesamt > 0){?>
        <div> <?php echo $mbGesamt . "MB von " . $mbMax . "MB belegt" ?> </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $mbGesamt?>"
                 aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prozentAnzahl?>%;">
                 <?php echo $prozentAnzahlgerundet . "%" ?>
            </div>
        </div>
        <?php } ?>


<script>

    // Pop Up Box mit Kommentarfeld, wenn Umbenennen-Button angeklickt wird

    function aendereFile(fileId, fileName){
        bootbox.prompt({
           title: "Bitte neuen Dateinamen eingeben",
            value: fileName,
            inputType: "text",
            buttons: {
                confirm: {
                    label: '&Auml;ndern',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Abbrechen',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result) {
                    request = $.ajax({
                        url: "umbenennen2.php",
                        type: "post",
                        data: "id=" + fileId + "&name=" + result,
                        success: function() {
                            window.location = "dashboard.php";
                        }
                    });
                }
            }
        });
    }


    // Pop Up Box mit Emailfeld, wenn Link versenden angeklickt wird

    function versendeLink(HASH){
        bootbox.prompt({
            title: "Bitte Emailadresse eintragen",
            inputType: "text",
            buttons: {
                confirm: {
                    label: 'Versenden',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Abbrechen',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result) {
                    request = $.ajax({
                        url: "linkverschicken.php",
                        type: "post",
                        data: "id=" + HASH + "&email=" + result,
                        success: function() {
                            window.location = "dashboard.php";
                        }
                    });
                }
            }
        });
    }




// Pop Up Box mit Sicherheitsabfrage, wenn löschen-Button angeklickt wird


    function loescheFile(fileId){
        bootbox.confirm({
            message: "Datei wirklich l&ouml;schen?",
            buttons: {
                confirm: {
                    label: 'Ja',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Nein',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result) {
                    request = $.ajax({
                        url: "loeschen.php",
                        type: "post",
                        data: "id=" + fileId,
                        success: function() {
                            window.location = "dashboard.php";
                        }
                    });
                }
            }
        });
    }


    // POP UP Box mit Link Anzeige

    function zeigeLink (HASH){
        bootbox.alert('<a target="new" href="'+ "https://mars.iuk.hdm-stuttgart.de/~sd103/datei_runterladen.php?id=" + HASH + '">'
            + "https://mars.iuk.hdm-stuttgart.de/~sd103/datei_runterladen.php?id=" + HASH + '</a>');

    }

</script>


<?php

//Datei hochladen


if ( $_FILES['uploaddatei']['name']  <> "" )
{


    // Dateitypen definieren und Kontrolle, ob Dateityp zulässig ist
    $zugelassenedateitypen = array("image/png", "image/jpeg", "image/gif" , "application/pdf" , "application/msword",
        "application/mspowerpoint", "application/msexcel", "application/");

    if ( ! in_array( $_FILES['uploaddatei']['type'] , $zugelassenedateitypen ))
    {
        echo "<p>Dateitype ist NICHT zugelassen</p>";
    }
    else
    {
        // Dateiname bereinigen (Funktion wird weiter unten definiert)
        $_FILES['uploaddatei']['name'] = dateiname_bereinigen($_FILES['uploaddatei']['name']);


        // File Name wird gehasht und in $new_filename gespeichert
        $file_extension = "." . pathinfo($_FILES['uploaddatei']['name'], PATHINFO_EXTENSION);
        $new_filename = md5($_FILES['uploaddatei']['name'] . time() . $_FILES['uploaddatei']['size']). $file_extension;


        // Wenn Dateiname zulässig ist, wird sie auf den Server und in die DB hochgeladen
        if ( $_FILES['uploaddatei']['name'] <> '' )
        {
            move_uploaded_file (
                $_FILES['uploaddatei']['tmp_name'] ,
                'hochgeladenes/files/'. $new_filename );


            //Neue Datei in Datenbank hochladen
            $sql= "INSERT INTO uploads (user_id, original_name, datei_name, groesse, datei_typ)
            VALUES ('" . $userid . "','" . ($_FILES['uploaddatei']['name']) . "','" . $new_filename. "','" . ($_FILES['uploaddatei']['size']) . "','" . $file_extension . "' )";
            $statement = $pdo->prepare($sql);
            $result = $statement->execute();


            $_SESSION['msg'] = "Hochladen war erfolgreich";
        }
        else
        {
            $_SESSION['msg'] = "Dateiname ist nicht zulässig";
            $_SESSION['msg_error'] = true;
        }
    }
}


function dateiname_bereinigen($dateiname)
{
    // Zeichen umschreiben, aus allen ä wird ae, ü -> ue, ß -> ss (je nach Sprache mehr Aufwand)

    $dateiname = strtolower ( $dateiname );
    $dateiname = str_replace ('"', "-", $dateiname );
    $dateiname = str_replace ("'", "-", $dateiname );
    $dateiname = str_replace ("*", "-", $dateiname );
    $dateiname = str_replace ("ß", "ss", $dateiname );
    $dateiname = str_replace ("ß", "ss", $dateiname );
    $dateiname = str_replace ("ä", "ae", $dateiname );
    $dateiname = str_replace ("ä", "ae", $dateiname );
    $dateiname = str_replace ("ö", "oe", $dateiname );
    $dateiname = str_replace ("ö", "oe", $dateiname );
    $dateiname = str_replace ("ü", "ue", $dateiname );
    $dateiname = str_replace ("ü", "ue", $dateiname );
    $dateiname = str_replace ("Ä", "ae", $dateiname );
    $dateiname = str_replace ("Ö", "oe", $dateiname );
    $dateiname = str_replace ("Ü", "ue", $dateiname );
    $dateiname = htmlentities ( $dateiname );
    $dateiname = str_replace ("&", "und", $dateiname );
    $dateiname = str_replace ("+", "und", $dateiname );
    $dateiname = str_replace ("(", "-", $dateiname );
    $dateiname = str_replace (")", "-", $dateiname );
    $dateiname = str_replace (" ", "-", $dateiname );
    $dateiname = str_replace ("\'", "-", $dateiname );
    $dateiname = str_replace ("/", "-", $dateiname );
    $dateiname = str_replace ("?", "-", $dateiname );
    $dateiname = str_replace ("!", "-", $dateiname );
    $dateiname = str_replace (":", "-", $dateiname );
    $dateiname = str_replace (";", "-", $dateiname );
    $dateiname = str_replace (",", "-", $dateiname );
    $dateiname = str_replace ("--", "-", $dateiname );

    // Heilfunktion
    $dateiname = filter_var($dateiname, FILTER_SANITIZE_URL);
    return ($dateiname);
}

?>

</div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>



<?php
include("footer.php");
?>

</body>
</html>