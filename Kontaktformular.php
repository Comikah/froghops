<html lang="de">
<head>
<?php
include("head.php");

?>

</head>
<body id="dashboard" data-spy="scroll" data-target="#navbar">


<?php

include("header.php");


$showForm = true;



//Prüfung, ob Werte in das Formular eingetragen wurde
if (isset($_GET["Kontaktformular"]) && isset($_POST["mail"]) && isset($_POST["betreff"]) && isset($_POST["nachricht"])) {

	//Versendungsinformationen (aus dem Formular) in Variable speichern
	$an = "ste.duscher@googlemail.com";
	$vorname = $_POST["vorname"];
	$nachname = $_POST["nachname"];
	$email = 'From: ' . $_POST['mail'] . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$betreff = $_POST["betreff"];
	$nachricht = $_POST["nachricht"];


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


	$showForm = false;

};

if($showForm):



endif; //Endif von if($showForm)

if ($showForm == false){
	$_SESSION['msg'] = "Email erfolgreich versendet!";

}

?>



<div class="container">
	<div class="row">

 <!-- Formular für die Kontaktaufnahme-->

		<div class="col-md-3">

		</div>


		<div class="col-md-6" id="rahmen">

			<h1 class="ueberschrift" id="center"> Kontakt </h1>
			<br>

			<div id="rahmenInnen">
		<form action="Kontaktformular.php?Kontaktformular=1" method="post" name="kontakt">


	<input class="form-control" type="text" id="nachrichtKontaktformular" name="vorname" placeholder="Vorname"> <br>

	<input class="form-control" type="text" id="nachrichtKontaktformular" name="nachname" placeholder="Nachname"> <br>

	<input class="form-control" type="text" id="nachrichtKontaktformular" name="mail" placeholder="Email"> <br>

	<input class="form-control" type="text" id="nachrichtKontaktformular" name="betreff" placeholder="Betreff"> <br>

	<textarea class="form-control" id="nachrichtKontaktformular" rows="5"  name="nachricht">
    </textarea>
	<br>

	<input class="btn btn-primary" id="submit" type="submit" name="submit" value="Senden">

</form>
			</div>
		</div>
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