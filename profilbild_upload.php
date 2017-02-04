<?php
session_start();
include_once("userdata.php");

if(!isset($_SESSION['userid'])) {
    header('Location: login.php');
    // die('Bitte zuerst <a href="login.php">einloggen</a>!');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

echo "Hallo User: ".$userid;



if ( $_FILES['bild']['name']  <> "" )
{
    // Datei wurde durch HTML-Formular hochgeladen
    // und kann nun weiterverarbeitet werden

    // Dateitypen definieren und Kontrolle, ob Dateityp zulässig ist
    $zugelassenedateitypen = array("image/png", "image/jpeg", "image/gif");

    if ( ! in_array( $_FILES['bild']['type'] , $zugelassenedateitypen ))
    {
        echo "<p>Dateitype ist NICHT zugelassen</p>";
    }
    else
    {
        // Test ob Dateiname in Ordnung
        $_FILES['bild']['name'] = dateiname_bereinigen($_FILES['bild']['name']);

        // Wenn Dateiname zulässig ist, wird sie auf den Server und in die DB hochgeladen
        if ( $_FILES['bild']['name'] <> '' )
        {
            move_uploaded_file (
                $_FILES['bild']['tmp_name'] ,
                'hochgeladenes/profile/'. $_FILES['bild']['name'] );


            //Neue Datei in Datenbank aktualisieren/updaten
            $sql= "UPDATE users 
            SET Profilbild = ('" . ($_FILES['bild']['name']) . "') WHERE user_id = $userid ";
            $statement = $pdo->prepare($sql);
            $result = $statement->execute();

            //print_r($statement->errorInfo());

            // Ausgeben des $_FILES Inhalt, bzw. hochgeladenen Inhalts
            echo "<p>Hochladen war erfolgreich: ";
            echo '<a href="hochgeladenes/profile/'. $_FILES['bild']['name'] .'">';
            echo 'hochgeladenes/profile/'. $_FILES['bild']['name']." / ". $_FILES['bild']['type'].
                " / ". $_FILES['bild']['size']; // (Evtl. mit STRIPTEMPNAME FÜR HASHCODE IM LINK!!)
            echo '</a>';
        }
        else
        {
            echo "<p>Dateiname ist nicht zulässig</p>";
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

    // "Heilfunktion"
    $dateiname = filter_var($dateiname, FILTER_SANITIZE_URL);
    return ($dateiname);
}


?>

<html>
<head></head>

<body>

<form id="bildupload" name="bildupload" enctype="multipart/form-data" action="profilbild_upload.php" method="post" >
    Bild: <input type="file" name="bild" size="60" maxlength="255" >
    <input type="Submit" name="submit" value="Datei hochladen">
</form>

</body>
</html>