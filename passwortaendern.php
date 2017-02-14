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

//Nutzer ID wird in Variable gespeichert
$userid = $_SESSION['userid'];


    //Prüfung, ob FOrmular ausgefüllt wurde
    if(isset($_GET['pwaendern'])) {
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $passwortNeu = $_POST['passwort3'];


        //Prüft ob Passwörter richtig eingegeben wurden
        if(($passwort != $passwort2) && ($passwort == $passwortNeu) ) {
        //echo 'Die Passwörter stimmen nicht überein oder das neugewählte Passwort ist unverändert! <br>';
            $_SESSION['msg'] = 'Die Passwörter stimmen nicht überein oder das neugewählte Passwort ist unverändert!';
            $_SESSION['msg_error'] = true;
    }



    //Keine Fehler, wir können das Passwort ändern
    //if(!$errorMessage) {

        $password_hash = password_hash($passwortNeu, PASSWORD_DEFAULT);

    $statement2 = $pdo->prepare("UPDATE users SET passwort = '".$password_hash."' WHERE user_id = '".$userid."' ");

        if ($statement2->execute(array(':passwort' => $password_hash))){
            $_SESSION['msg'] = "Das Passwort wurde erfolgreich geändert";

        } else {
            $error = 'Beim Ändern ist leider ein Fehler aufgetreten <br>'.$pdo->errorInfo();
        $_SESSION['msg'] = $error;
        $_SESSION['msg_error'] = true;
        }

}

/*
if(isset($errorMessage)) {

    $_SESSION['msg'] = $errorMessage;
    $_SESSION['msg_error'] = true;

}*/
?>


<!-- Formular für Passwort ändern -->
<!--
<form action="passwortaendern.php?pwaendern=1" method="post">
    Passwort:<br>
    <input type="password" size="40" maxlength="250" name="passwort1"><br><br>
    Passwort wiederholen:<br>
    <input type="password" size="40" maxlength="250" name="passwort2"><br><br>
    Neues Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort3"><br>

    <input type="submit" value="Ändern">

</form>
-->


<div class="container">
    <div class="row">

        <!-- Formular für Passwort ändern-->

        <div class="col-md-3">

        </div>


        <div class="col-md-6" id="rahmen">

            <h1 class="ueberschrift" id="center"> Passwort ändern </h1>
            <br>

            <div id="rahmenInnen">
<br>
<form id="bildupload nachrichtKontaktformular"  action="passwortaendern.php?pwaendern=1" method="post">

    <input type="password" class="form-control" id="nachrichtKontaktformular" name="passwort1" placeholder="Altes Passwort"> <br>

    <input type="password" class="form-control" id="nachrichtKontaktformular"  name="passwort2" placeholder="Altes Passwort erneut eingeben"> <br>

    <input type="password" class="form-control" id="nachrichtKontaktformular"  name="passwort3" placeholder="Neues Passwort"> <br>

    <input class="btn btn-primary" id="submit" type="Submit" name="submit" value="Ändern">

</form>
</div>
</div>
</div>
</div>


<?php include("footer.php"); ?>

</body>
</html>