<html lang="de">
<head>
<?php
include("head.php");

    /* if(!isset($_SESSION['userid'])) {
		header('Location: login.php');
		// die('Bitte zuerst <a href="login.php">einloggen</a>!');
	} */

?>
</head>
<body id="dashboard" data-spy="scroll" data-target="#navbar">
<?php

include("header.php");


$showForm = true;

// var_dump($_POST); - Für das Überprüfen der POST-Werte

if (isset($_GET["Kontaktformular"]) && isset($_POST["mail"]) && isset($_POST["betreff"]) && isset($_POST["nachricht"])) {

	//Versendungsinformationen (aus dem Formular) in Variable speichern
	$an = "ste.duscher@googlemail.com";
	$vorname = $_POST["vorname"];
	$nachname = $_POST["nachname"];
	$email = $_POST["mail"];
	$betreff = $_POST["betreff"];
	$nachricht = $_POST["nachricht"];

	// Header wird UTF-8 fähig gemacht
	//$mail_header = 'From:' . $email . "n";
	//$mail_header = 'Content-type: text/plain; charset=UTF-8' . "rn";

	// Namen zusammenfügen
	$name = $vorname.' '.$nachname;

	//Nachrichtenlayout wird erstellt
	$message = "
      Name: $name
      Email: $email
      Nachricht: $nachricht
      ";


	//Email senden
	mail($an, $betreff, $message, $email);


	//echo("Email erfolgreich versendet!");
	// exit();

	$showForm = false;

};

if($showForm):



endif; //Endif von if($showForm)

if ($showForm == false){
	echo ("Email erfolgreich versendet!"); //Pop UP ZEICHEN!

}

?>


<!-- Formular für die Kontaktaufnahme-->
<form action="Kontaktformular.php?Kontaktformular=1" method="post" name="kontakt">
	<h1>Kontakt </h1>
	<label for="vorname"> Vorname: </label>
	<input type="text" id="vorname" name="vorname">
	<label for="nachname"> Nachname: </label>
	<input type="text" id="nachname" name="nachname"> <br> <br>
	<label for="Mail"> E-Mail-Adresse: </label>
	<input type="text" id="mail" name="mail"> <br> <br>
	<label for="Betreff"> Betreff: </label>
	<input type="text" id="betreff" name="betreff"> <br> <br>
	<label for="nachricht"> Nachricht: </label><br>
	<textarea id="nachricht" rows="10" cols="100" name="nachricht">
    </textarea>
	<br>

	<input id="submit" type="submit" name="submit" value="Senden">
</form>
<br><br>


<?php
include("footer.php");
?>


</body>
</html>