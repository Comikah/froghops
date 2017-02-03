<?php

$showForm = true;

// var_dump($_POST);

if (isset($_GET["Kontaktformular"]) && isset($_POST["mail"]) && isset($_POST["betreff"]) && isset($_POST["nachricht"])) {

	//Versendungsinformationen (aus dem Formular) in Variable speichern
	$an = "ste.duscher@googlemail.com";

	// $vorname = $_POST["vorname"];

	//$nachname =($_POST["nachname"];

	$email = $_POST["mail"];

	$betreff = $_POST["betreff"];

	$nachricht = $_POST["nachricht"];

	// Header wird UTF-8 fähig gemacht
	// $mail_header = 'From:' . $email . "n";

	//  $mail_header = 'Content-type: text/plain; charset=UTF-8' . "rn";

	// Namen zusammenfügen
	$name = $vorname.' '.$nachname;

	//Nachrichtenlayout wird erstellt


	$message = "
      Name: $name
      Email: $email
      Nachricht: $nachricht
      ";




// $mailSent = @mail($an, $email, $nachricht, "From: ".$vorname.''.$nachname);

	//Email senden
	mail($an, $betreff, $message, $email);


	//echo("Email erfolgreich versendet!");
	// exit();
	$showForm = false;

};

if($showForm):
?>



<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Kontaktformular</title>
</head>
<body>

<h1><img src="logo_frosch_bunt.png" alt="Frosch" width="133" height="133" align="left"></h1>
<br><br><br><br><br><br><br>


<form action="Kontaktformular.php?Kontaktformular=1" method="post" name="kontakt">
	<h1>Kontakt <img src="brief.png" alt="Brief" width="80" height="50"></h1>
	<label for="vorname"> Vorname: </label>
	<input type="text" id="vorname" name="vorname">
	<!--<label for="nachname"> </label>
	<input type="text" id="nachname" name="nachname"> <br> <br> -->
	<label for="Mail"> E-Mail-Adresse: </label>
	<input type="text" id="mail" name="mail"> <br> <br>
	<label for="Betreff"> Betreff: </label>
	<input type="text" id="betreff" name="betreff"> <br> <br>
	<label for="nachricht"> Nachricht: </label><br>
	<textarea id="nachricht" rows="10" cols="100" name="nachricht">
    </textarea>
	<br><br>

	<input id="submit" type="submit" name="submit" value="Senden">
</form>
<br><br>




</body>
</html>

	<?php
endif; //Endif von if($showForm)

if (showForm == false){
	echo ("Email erfolgreich versendet!");
}
?>




