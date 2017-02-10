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

<h1> Profil von <?php echo $username ?> </h1>
<?php

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
            unlink($dir . "$loeschedatei");

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


    $sqli= "SELECT profilbild FROM users WHERE user_id = $userid";
    $statement = $pdo->prepare($sqli);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $row = $statement->fetch();


        echo "<div>";
        echo "<img id='profilbildG' src='hochgeladenes/profile/".$row["profilbild"]."'>";
        echo "</div>";

     //print_r($row);
     //echo "dies ist die Zahl ".$row;
    // Bild war varchar (200)
?>




<!-- Formular für den Upload des Profilbildes -->
<form id="bildupload" name="bildupload" enctype="multipart/form-data" action="profilbild_upload.php" method="post" >
    Bild: <input type="file" name="bild" size="60" maxlength="255" >
    <input type="Submit" name="submit" value="Bild hochladen">
</form>


<?php
include("passwortaendern.php");
?>



<?php
include("footer.php");
?>

</body>
</html>