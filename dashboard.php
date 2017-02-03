

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

?>


<?php




if ( $_FILES['uploaddatei']['name']  <> "" )
{
    // Datei wurde durch HTML-Formular hochgeladen
    // und kann nun weiterverarbeitet werden

    // Dateitypen definieren und Kontrolle, ob Dateityp zulässig ist
    $zugelassenedateitypen = array("image/png", "image/jpeg", "image/gif" , "application/pdf" , "application/msword",
        "application/mspowerpoint", "application/msexcel", "application/");

    if ( ! in_array( $_FILES['uploaddatei']['type'] , $zugelassenedateitypen ))
    {
        echo "<p>Dateitype ist NICHT zugelassen</p>";
    }
    else
    {
        // Test ob Dateiname in Ordnung
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
                // $_FILES['uploaddatei']['tmp_name'] ,
                // 'hochgeladenes/files/'. $_FILES['uploaddatei']['name'] );

            //Neue Datei in Datenbank hochladen
            $sql= "INSERT INTO uploads (user_id, original_name, datei_name, groesse, datei_typ)
            VALUES ('" . $userid . "','" . ($_FILES['uploaddatei']['name']) . "','" . $new_filename. "','" . ($_FILES['uploaddatei']['size']) . "','" . $file_extension . "' )";
            $statement = $pdo->prepare($sql);
            $result = $statement->execute();

        // Ausgeben des $_FILES Inhalt, bzw. hochgeladenen Inhalts
            echo "<p>Hochladen war erfolgreich: ";
            echo '<a href="hochgeladenes/files/'. $_FILES['uploaddatei']['name'] .'">';
            echo 'hochgeladenes/files/'. $_FILES['uploaddatei']['name']." / ". $_FILES['uploaddatei']['type'].
                " / ". $_FILES['uploaddatei']['size']; // (Evtl. mit STRIPTEMPNAME FÜR HASHCODE IM LINK!!)
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

    // Heilfunktion
    $dateiname = filter_var($dateiname, FILTER_SANITIZE_URL);
    return ($dateiname);
}

?>

<html>

<form name="uploadformular" enctype="multipart/form-data" action="dashboard.php" method="post" >
    Datei: <input type="file" name="uploaddatei" size="60" maxlength="255" >
    <input type="Submit" name="submit" value="Datei hochladen">
</form>


<!-- Ab hier die Dateienliste-->
<h1>Dateienliste</h1>
<ul>
    <?php

    $ordner = "/home/sd103/public_html/hochgeladenes/files/"; //Pfad, wo die Datein sind, hier müsste also
    // Verbindung mit der Datenbank hergestellt werden


    $alledateien = scandir($ordner); // Sortierung A-Z / Dateien in Ordner werden in Variable gespeichert

    foreach ($alledateien as $datei) {

        $dateiinfo = pathinfo($ordner."/".$datei);  //zeigt Typ der Datei an
        $size = ceil(filesize($ordner."/".$datei)/1024);//1024 steht für kb
        $date = date("d.m.Y - H:i",filemtime ($ordner."/".$datei));


        if ($datei != "." && $datei != ".."  && $datei != "_notes") {
            ?>
            <li><a href="<?php echo $dateiinfo['dirname']."/".$dateiinfo['basename'];?>"><?php echo $dateiinfo['filename']; ?></a> (<?php echo $dateiinfo['extension']; ?> |<?php echo $date; ?> | <?php echo $size ; ?>kb)</li>
            <?php
        };
    };
    ?>
</ul>
<!-- Dateienliste geht bis hier - von Anabel! -->



<p> <a href="logout.php">Abmelden!</a> <p>
</html>