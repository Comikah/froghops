<html lang="de">
<head>
    <link rel="stylesheet" href="Sonstiges/Dropzone/dropzone.css">

    <?php
    include("head.php");

    if(!isset($_SESSION['userid'])) {
        header('Location: login.php');
    }
    ?>

    <!-- Java Script - Einstellung für Drag and Drop -->
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

<body id="dashboard" class="loginkomplett" data-spy="scroll" data-target="#navbar">
<?php

include("header.php");

?>
<div class="container">
    <div class="row">

<h1 id="center" class="ueberschrift"> Mein FrogDrops </h1>
        <br>
<h3 id="center"> Laiche deine Daten hier im Teich ab </h3>



        <!-- Drag and Drop Formular -->
        <div class="col-md-3">  </div>
        <div class="col-md-6 ">

        <form id="dzeinstellung" name="uploadformular" action="dashboard.php" class="dropzone" > </form>
        </div>
        <div class="col-md-3">  </div>

<?php

/*************************************/
/* Hochgeladene Daten anzeigen lassen*/
/*************************************/

//Daten aus Uploads auslesen
$sqli= "SELECT * FROM uploads WHERE user_id = $userid";
$statement = $pdo->prepare($sqli);
$statement->execute();
$statement->setFetchMode(PDO::FETCH_ASSOC);


?>

<!-- Tabelle mit Inhalten aus uploads erstellen-->

     <!-- Tabellenkopf erstellen-->
        <div class="table-container">
<table class="table table-hover table-responsive table-striped" >

    <thead id="center">
    <th id='center' class="col-sm-3">Dateiname</th>
    <th id='center' class="col-sm-2">Gr&ouml;ße</th>
    <th id='center'> &Auml;ndern</th>
    <th id='center'> L&ouml;schen</th>
    <th id='center'> Notiz</th>
    <th id='center'> Freigabe </th>
    <th id='center'> Anschauen</th>
    <th id='center'> Versenden</th>


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
        //$row - Daten werden zur verfügung gestellt
        extract($row);
        echo "<tr>";
        echo "<td > <i id=\"tdicon\" class=\"fa fa-download\" aria-hidden=\"true\"></i> <a target='new' href='dateiAnzeigen2.php?id=".$row["id"]."'> ".$row["original_name"]."  </a> </td>";

        echo "<td id='center'>" . umwandlung($groesse).  " </td>";

        echo "<td id='center' class=\"col-sm-1\"> " . '<a onclick="aendereFile(' . $row["id"] . ',\'' . $row["original_name"]. '\')"><i id="tdicon" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>' . " </td>";

        echo "<td id='center' class=\"col-sm-1\"> " . '<a onclick="loescheFile(' . $row["id"] . ')"><i id="tdicon" class="fa fa-trash" aria-hidden="true"></i> </a>' . " </td>";

        // ID und bisherige Notiz werden in FUnktion übergeben. Notiz wird damit beim Aufruf direkt angezeigt (-> Value)
        echo "<td id='center'> " . '<a onclick="zeigeNotiz(' . $row["id"] . ',\'' . $row["notiz"]. '\')"><i id=\"tdicon\" class="fa fa-comment" aria-hidden="true"></i></a>' . "</td>";

        //Wenn Werte in "freigegeben" stehen, werden die Funktionen zeigeLink, versendeLink und Freigabe beenden angezeigt
        if ($row['freigegeben'] != NULL) {
            echo "<td id='center'><a href='dateiFreigabeBeenden.php?id=" . $row["id"] . "'><i id=\"tdicon\" class=\"fa fa-unlock\" aria-hidden=\"true\"></i></a></td>";
            echo "<td id='center'><a onclick='zeigeLink(\"".$row['freigegeben']."\")'><i id=\"tdicon\" class=\"fa fa-external-link\" aria-hidden=\"true\"></i></a></td>";
            echo "<td id='center'><a onclick='versendeLink(\"".$row['freigegeben']."\")'><i id=\"tdicon\" class=\"fa fa-envelope\" aria-hidden=\"true\"></i></a></td>";

        }else {
            echo "<td id='center'><a href='dateiFreigabe.php?id=" . $row["id"] . "'><i id=\"tdicon\" class=\"fa fa-lock\" aria-hidden=\"true\"></i></a></td>";
            echo "<td> </td>";
            echo "<td> </td>";
        }

            echo "</tr>";




        //Variable erstellen mit Gesamtgröße aller Dateien und maximale MB festlegen
        $mbGesamt += umwandlung($groesse);
        $mbMax = 50;

    }
        // Variable erstellen für Prozentanzeige (Verbrauch in Relation zu mbMax)
    if ($mbGesamt > 0) {
        $prozentAnzahl = ($mbGesamt / $mbMax) * 100;
        $prozentAnzahlgerundet = round($prozentAnzahl, 0);
}
    ?>

    </tbody>
</table>
</div>

<script>
    <?php include("popupFelder.js")?>
</script>

<!-- Progess Bar, als Anzeige für den aktuellen MB-Stand -->
        <br>
        <?php  if ($mbGesamt > 0){?>
        <div id="center"><b> <?php echo $mbGesamt . "MB von " . $mbMax . "MB belegt" ?> </b></div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $mbGesamt?>"
                 aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prozentAnzahl?>%;">
                 <?php echo $prozentAnzahlgerundet . "%" ?>
            </div>
        </div>
        <?php } ?>





<?php

/********************/
/* Datei hochladen */
/*******************/


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




<?php
include("footer.php");
?>

</body>
</html>