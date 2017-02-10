<html lang="de">
<head>
    <?php
    include("head.php");

    if(!isset($_SESSION['userid'])) {
        header('Location: login.php');
        // die('Bitte zuerst <a href="login.php">einloggen</a>!');
    }
    ?>


</head>

<body id="dashboard" data-spy="scroll" data-target="#navbar">
<?php



include("header.php");

?>
<div class="container">
    <div class="row">


<h1 id="center"> Mein FrogDrops </h1>

<!-- Uploadformular erstellen (Uploadfunktion weiter unten)-->
<form name="uploadformular" enctype="multipart/form-data" action="dashboard.php" method="post" >
    Datei: <input type="file" name="uploaddatei" size="60" maxlength="255" >
    <input type="Submit" name="submit" value="Datei hochladen">
</form>


<?php


//Daten aus Uploads auslesen
$sqli= "SELECT * FROM uploads WHERE user_id = $userid";
$statement = $pdo->prepare($sqli);
$statement->execute();
$statement->setFetchMode(PDO::FETCH_ASSOC);
$row = $statement->fetch();

//
//Versuche für Löschen aus dem Server
//
//$loeschedatei = $row["datei_name"];
//echo $loeschedatei;
//$hallo = "4";
//print_r($loeschedatei);

//$loeschedatei = $row["datei_name"];
//$dir = "/home/sd103/public_html/hochgeladenes/files/";
//unlink($dir . "$loschedatei");


//$ordnerinhalt = scandir($ordner);

//readdir($loeschedatei);
//print_r($ordnerinhalt);
//echo($ordnerinhalt[$hallo] )
//["' . $loeschedatei. '"]


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
        //echo "<td> ".$row["groesse"]." ".Byte."</td>";
        //echo "<td> " . '<a onclick="aendereFile(' . $row["id"] . ',' . $row["original_name"]. ')">umbenennen</a>' . " </td>";
        echo "<td><a href='umbenennen.php?id=".$row["id"]."'>umbenennen</a></td>";
        echo "<td> " . '<a onclick="loescheFile(' . $row["id"] . ')">l&ouml;schen</a>' . " </td>";
        //echo "<td><a href='loeschen.php?id=".$row["id"]."'>l&ouml;schen</a></td>";
        //echo "<td> " . '<a href="" onclick="removeday()" class="deletebtn">teilen</a>' . " </td>";
        echo "<td><a href='linkverschicken.php?id=".$row["id"]."'>teilen</a></td>";
        echo "<td><a href='notiz.php?id=".$row["id"]."'>Notiz</a></td>";
        echo "</tr>";
    }


    //$var =  "<script> downloadFile('./hochgeladenes/files/Konzeptdokument_Musikvideo_Gruppe_2b_PDF.pdf')  </script>" ;

    //$file = md5($var);

    ?>
    </tbody>
</table>
<!--
<script>

    function aendereFile(fileId, fileName){
        bootbox.prompt({
           title: "Bitte neuen Dateinamen eingeben",
            //value: fileName,
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
                        data: "id=" + fileId,
                        success: function() {
                            window.location = "dashboard.php";
                        }
                    });
                }
            }
        });
    }

</script>
-->

<!-- Pop Up Box mit Sicherheitsabfrage, wenn löschen-Button angeklickt wird  -->
<script>

    function loescheFile(fileId){
        bootbox.confirm({
            message: "Datei wirklich l&ouml;schen?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
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



//include("download.php");

//md5(' . echo "<script> downloadFile('./hochgeladenes/profile/img_5743.jpg') </script>" . ');
//echo "<script> downloadFile('./hochgeladenes/profile/backflip-spielplatz.jpg') </script>"



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