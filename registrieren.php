<html lang="de">
<head>

    <?php
    include("head.php");
    ?>
</head>
<body id="login" data-spy="scroll" data-target="#navbar">



<?php
include("header.php");

$zeigeFormular = true; //Variable ob das Registrierungsformular angezeigt werden soll

// Prüfung, ob Formular ausgefüllt wurde und definition von Variablen er eingegeben Werte
if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $_SESSION['msg'] = 'Bitte eine gültige E-Mail-Adresse eingeben';
        $_SESSION['msg_error'] = true;
        $error = true;
    }
    if(strlen($passwort) == 0) {
        //echo 'Bitte ein Passwort angeben<br>';
        $_SESSION['msg'] = 'Bitte ein Passwort angeben';
        $_SESSION['msg_error'] = true;
        $error = true;
    }

        if($passwort != $passwort2) {
        //echo 'Die Passwörter müssen übereinstimmen<br>';
            $_SESSION['msg'] = 'Die Passwörter müssen übereinstimmen!';
            $_SESSION['msg_error'] = true;
        $error = true;
    }

    //Überprüfen, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            //echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $_SESSION['msg'] = 'Diese E-Mail-Adresse ist bereits vergeben!';
            $_SESSION['msg_error'] = true;

            $error = true;
        }
    }

    //Wenn es keine Fehlermeldung gab, kann der Nutzer registriert werden
    if(!$error) {
        //Passwort wird gehasht
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        //Eingegebene Werte werden in Datenbank gespeichert
        $statement = $pdo->prepare("INSERT INTO users (user_id, email, vorname, nachname, passwort) VALUES ('', :email, :vorname, :nachname, :passwort)");
        $result = $statement->execute(array(':email' => $email, ':vorname' => $vorname, ':nachname' => $nachname, ':passwort' => $passwort_hash));

        //Wenn INSERT erfolgreich, dann wird das Formular geschlossen und POP UP Meldung erscheint!
        if($result) {
            $_SESSION['msg'] = 'Du wurdest erfolgreich registriert. <a href="login.php">Zur Startseite</a>';
            $zeigeFormular = false;
        } else {
            $_SESSION['msg'] = 'Beim Abspeichern ist leider ein Fehler aufgetreten <br>'.$pdo->errorInfo();
        }
    }
}

if($zeigeFormular) {
    ?>


    <!-- Formluar für das Registrieren -->
<div class="container">
    <div class="row">

        <div class="col-md-3"> </div>

        <div class="col-md-6" id="rahmen">

            <h1 class="ueberschrift" id="center"> Registrieren </h1>
            <br>

            <div id="rahmenInnen">
    <form id="nachrichtKontaktformular" action="registrieren.php?register=1" method="post">

        <input  class="form-control" type="email" size="40" maxlength="250" name="email" placeholder="Email"><br>


        <input  class="form-control" type="text" size="40" maxlength="250" name="vorname" placeholder="Vorname"><br>


        <input  class="form-control" type="text" size="40" maxlength="250" name="nachname" placeholder="Nachname"><br>


        <input  class="form-control" type="password" size="40"  maxlength="250" name="passwort" placeholder="Passwort"><br>


        <input  class="form-control" type="password" size="40" maxlength="250" name="passwort2" placeholder="Passwort wiederholen"><br>

        <input class="btn btn-primary" type="submit" value="Registrieren">
    </form>
    <p> Bereits <a href="login.php">registriert</a>?</p>
 </div>

</div>
    </div>
</div>


    <?php
} //Ende von if($zeigeFormular)

include("footer.php");
?>

</body>
</html>