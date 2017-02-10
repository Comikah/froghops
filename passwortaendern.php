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

    if(isset($_GET['pwaendern'])) {
    $error = false;
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $passwortNeu = $_POST['passwort3'];

/*
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
*/
        if(($passwort != $passwort2) && ($passwort == $passwortNeu) ) {
        echo 'Die Passwörter stimmen nicht überein oder das neugewählte Passwort ist unverändert! <br>';
        $error = true;
    }



    //Keine Fehler, wir können das Passwort ändern
    if(!$error) {

        $password_hash = password_hash($passwortNeu, PASSWORD_DEFAULT);

    $statement2 = $pdo->prepare("UPDATE users SET passwort = '".$password_hash."' WHERE user_id = '".$userid."' ");
    $statement2->execute(array(':passwort' => $password_hash));


        } else {
            echo 'Beim Ändern ist leider ein Fehler aufgetreten <br>'.$pdo->errorInfo();
        }

}

if(isset($errorMessage)) {
    echo $errorMessage;
    echo "<a href= passwortaendern.php > Erneut eingeben </a> <br><br>";
}
?>

<form action="passwortaendern.php?pwaendern=1" method="post">
    Passwort:<br>
    <input type="password" size="40" maxlength="250" name="passwort1"><br><br>
    Passwort wiederholen:<br>
    <input type="password" size="40" maxlength="250" name="passwort2"><br><br>
    Neues Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort3"><br>

    <input type="submit" value="Ändern">

</form>


<?php
include("footer.php");
?>

</body>
</html>