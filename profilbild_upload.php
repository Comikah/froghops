<html lang="de">
<head>

<?php
include("head.php");

if(!isset($_SESSION['userid'])) {
    header('Location: login.php');
}
?>


</head>
<body id="dashboard" data-spy="scroll" data-target="#navbar">

<?php
include("header.php");
?>



<div class="container">
    <div class="row">

        <!-- Formular für den Upload des Profilbilds-->

        <div class="col-md-3">

        </div>


        <div class="col-md-6" id="rahmen">
<h1 class="ueberschrift" id="center"> Profil von <?php echo $username ?> </h1>

            <br>

            <div id="rahmenInnen">
<?php

//Prüfung, ob übergebene Datei leer ist
if ( $_FILES['bild']['name']  <> "" )
{


    // Dateitypen definieren und Kontrolle, ob Dateityp zulässig ist
    $zugelassenedateitypen = array("image/png", "image/jpeg", "image/gif");

    if ( ! in_array( $_FILES['bild']['type'] , $zugelassenedateitypen ))
    {
        //echo "<p>Dateitype ist NICHT zugelassen</p>";
        $_SESSION['msg'] = "Dateityp ist NICHT zugelassen";
        $_SESSION['msg_error'] = true;
    }
    else
    {
        // Test ob Dateiname in Ordnung
        $_FILES['bild']['name'] = dateiname_bereinigen($_FILES['bild']['name']);

        //Löschen der bisherigen Inhalte auf dem Server
        //Name des Profilbilds heraussuchen und Pfad der Datei auf dem Server in Variable festlegen
        $sql= "SELECT profilbild FROM users WHERE user_id = $userid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $loeschname = $stmt->fetch();

        $loeschedatei = $loeschname["profilbild"];
        $dir = "/home/sd103/public_html/hochgeladenes/profile/";


        // Wenn Dateiname zulässig ist, wird sie auf den Server und in die DB hochgeladen
        if ( $_FILES['bild']['name'] <> '')
        {
            move_uploaded_file (
                $_FILES['bild']['tmp_name'] ,
                'hochgeladenes/profile/'. $_FILES['bild']['name'] );

            //Aktuelle Datei vom Server löschen, bevor Neue in die Datenbank geladen wird
            if ($loeschedatei != NULL) {
                unlink($dir . "$loeschedatei");
            }

            //Neue Datei in Datenbank aktualisieren/updaten
            $sql= "UPDATE users 
            SET Profilbild = ('" . ($_FILES['bild']['name']) . "') WHERE user_id = $userid ";
            $statement = $pdo->prepare($sql);
            $result = $statement->execute();

            //print_r($statement->errorInfo());

            // Ausgeben des $_FILES Inhalt, bzw. hochgeladenen Inhalts
            $_SESSION['msg'] = "Profilbild hochladen war erfolgreich";
        }
        else
        {
            $_SESSION['msg'] = "Fehler: Dateiname nicht zulässig";
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

    // Dateiname wird nochmal gefiltert
    $dateiname = filter_var($dateiname, FILTER_SANITIZE_URL);
    return ($dateiname);
}

    // Profilbild mit SELECT heraussuchen und anzeigen lassen
    $sqli= "SELECT profilbild FROM users WHERE user_id = $userid";
    $statement = $pdo->prepare($sqli);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $row = $statement->fetch();

        If ($row["profilbild"] != NULL) {
            echo "<div>";
            echo "<img id='profilbildG' src='hochgeladenes/profile/" . $row["profilbild"] . "'>";
            echo "</div>";
        }


?>





          <br>
                <form id="bildupload" name="bildupload" enctype="multipart/form-data" action="profilbild_upload.php" method="post">

                    <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp" name="bild"> <br>

                    <input class="btn btn-primary btn-file" id="submit" type="Submit" name="submit" value="Bild hochladen">

                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

</body>
</html>